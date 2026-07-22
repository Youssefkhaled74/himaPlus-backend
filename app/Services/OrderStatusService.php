<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class OrderStatusService
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_ACCEPTED_ORDERS = 'accepted_orders';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_SCHEDULED = 'scheduled';
    public const STATUS_ACTIVE_SCHEDULED = 'active_scheduled';
    public const STATUS_COMPLETED_SCHEDULED = 'completed_scheduled';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_REJECTED = 'rejected';

    public function normalizeStatus(?string $status): string
    {
        $normalized = strtolower(trim((string) $status));
        $normalized = str_replace([' ', '-'], '_', $normalized);

        return match ($normalized) {
            'canceled' => self::STATUS_CANCELLED,
            'accepted' => self::STATUS_ACCEPTED_ORDERS,
            default => $normalized,
        };
    }

    public function resolveStatus(Order $order, array $context = []): array
    {
        $providerId = isset($context['provider_id']) ? (int) $context['provider_id'] : null;
        $audience = (string) ($context['audience'] ?? 'admin');

        $timeline = $order->relationLoaded('timeline') ? $order->timeline : $order->timeline()->get();
        $offers = $order->relationLoaded('offers') ? $order->offers : $order->offers()->get();
        $latestTimelineNo = (int) optional($timeline->sortByDesc('timeline_no')->first())->timeline_no;
        $hasAcceptedOffer = $this->resolveOfferStatus($offers, $providerId) === 'accepted';
        $hasRejectedOffer = $this->resolveOfferStatus($offers, $providerId) === 'rejected';
        $allOffersRejected = $offers->isNotEmpty() && $offers->every(function ($offer) use ($providerId) {
            if ($providerId && (int) $offer->provider_id !== $providerId) {
                return true;
            }

            return $this->normalizeOfferStatus($offer->status) === 'rejected';
        });
        $isScheduled = (int) $order->request_type === 2;
        $isCancelled = $timeline->contains(fn ($entry) => (int) $entry->timeline_no === 12);
        $isCompleted = $timeline->contains(fn ($entry) => (int) $entry->timeline_no === 6);

        if ($isCancelled) {
            return $this->makeState(self::STATUS_CANCELLED, $audience);
        }

        if ($isScheduled) {
            if ($isCompleted && $hasAcceptedOffer) {
                return $this->makeState(self::STATUS_COMPLETED_SCHEDULED, $audience);
            }

            if ($hasRejectedOffer && !$hasAcceptedOffer && $allOffersRejected) {
                return $this->makeState(self::STATUS_REJECTED, $audience);
            }

            if ($hasAcceptedOffer && $this->scheduleHasStarted($order)) {
                return $this->makeState(self::STATUS_ACTIVE_SCHEDULED, $audience);
            }

            return $this->makeState(self::STATUS_SCHEDULED, $audience);
        }

        if ($isCompleted) {
            return $this->makeState(self::STATUS_COMPLETED, $audience);
        }

        if ($hasRejectedOffer && !$hasAcceptedOffer && ($providerId || $allOffersRejected)) {
            return $this->makeState(self::STATUS_REJECTED, $audience);
        }

        if ($this->isProcessingTimeline($latestTimelineNo)) {
            return $this->makeState(self::STATUS_PROCESSING, $audience);
        }

        if ($hasAcceptedOffer || $this->isConfirmedTimeline($latestTimelineNo)) {
            return $this->makeState(self::STATUS_CONFIRMED, $audience);
        }

        return $this->makeState(self::STATUS_PENDING, $audience);
    }

    public function applyStatusFilter(Builder $query, ?string $status, array $context = []): Builder
    {
        $status = $this->normalizeStatus($status);
        $providerId = isset($context['provider_id']) ? (int) $context['provider_id'] : null;

        if ($status === '') {
            return $query;
        }

        return match ($status) {
            self::STATUS_PENDING => $this->applyPendingFilter($query, $providerId),
            self::STATUS_CONFIRMED,
            self::STATUS_ACCEPTED_ORDERS => $this->applyConfirmedFilter($query, $providerId),
            self::STATUS_PROCESSING => $this->applyProcessingFilter($query, $providerId),
            self::STATUS_COMPLETED => $this->applyCompletedFilter($query),
            self::STATUS_SCHEDULED => $this->applyScheduledFilter($query, $providerId),
            self::STATUS_ACTIVE_SCHEDULED => $this->applyActiveScheduledFilter($query, $providerId),
            self::STATUS_COMPLETED_SCHEDULED => $this->applyCompletedScheduledFilter($query, $providerId),
            self::STATUS_CANCELLED => $this->applyCancelledFilter($query),
            self::STATUS_REJECTED => $this->applyRejectedFilter($query, $providerId),
            default => $query,
        };
    }

    public function countByStatus(Builder $query, string $status, array $context = []): int
    {
        return (clone $this->applyStatusFilter(clone $query, $status, $context))->count();
    }

    public function makeState(string $status, string $audience = 'admin'): array
    {
        $status = $this->normalizeStatus($status);

        $adminMap = [
            self::STATUS_PENDING => ['label' => __('admin.pages.orders.statuses.pending'), 'class' => 'bg-warning-subtle text-warning'],
            self::STATUS_CONFIRMED => ['label' => __('admin.pages.orders.statuses.confirmed'), 'class' => 'bg-success-subtle text-success'],
            self::STATUS_ACCEPTED_ORDERS => ['label' => __('admin.pages.orders.statuses.accepted'), 'class' => 'bg-success-subtle text-success'],
            self::STATUS_PROCESSING => ['label' => __('admin.pages.orders.statuses.processing'), 'class' => 'bg-primary-subtle text-primary'],
            self::STATUS_COMPLETED => ['label' => __('admin.pages.orders.statuses.completed'), 'class' => 'bg-success-subtle text-success'],
            self::STATUS_SCHEDULED => ['label' => __('admin.pages.orders.statuses.scheduled'), 'class' => 'bg-secondary-subtle text-secondary'],
            self::STATUS_ACTIVE_SCHEDULED => ['label' => __('admin.pages.orders.statuses.active'), 'class' => 'bg-primary-subtle text-primary'],
            self::STATUS_COMPLETED_SCHEDULED => ['label' => __('admin.pages.orders.statuses.completed'), 'class' => 'bg-success-subtle text-success'],
            self::STATUS_CANCELLED => ['label' => __('admin.pages.orders.statuses.canceled'), 'class' => 'bg-danger-subtle text-danger'],
            self::STATUS_REJECTED => ['label' => __('admin.pages.orders.statuses.rejected'), 'class' => 'bg-danger-subtle text-danger'],
        ];

        $frontMap = [
            self::STATUS_PENDING => ['label' => __('messages.status_pending'), 'class' => 'chip-pending'],
            self::STATUS_CONFIRMED => ['label' => __('messages.status_confirmed'), 'class' => 'chip-confirmed'],
            self::STATUS_ACCEPTED_ORDERS => ['label' => __('messages.status_confirmed'), 'class' => 'chip-confirmed'],
            self::STATUS_PROCESSING => ['label' => __('messages.status_processing'), 'class' => 'chip-processing'],
            self::STATUS_COMPLETED => ['label' => __('messages.status_completed'), 'class' => 'chip-completed'],
            self::STATUS_SCHEDULED => ['label' => __('messages.status_scheduled'), 'class' => 'chip-upcoming'],
            self::STATUS_ACTIVE_SCHEDULED => ['label' => __('messages.status_active'), 'class' => 'chip-active'],
            self::STATUS_COMPLETED_SCHEDULED => ['label' => __('messages.status_completed'), 'class' => 'chip-completed'],
            self::STATUS_CANCELLED => ['label' => __('messages.status_cancelled'), 'class' => 'chip-cancelled'],
            self::STATUS_REJECTED => ['label' => __('messages.status_rejected'), 'class' => 'chip-rejected'],
        ];

        $payload = $audience === 'admin' ? $adminMap[$status] ?? $adminMap[self::STATUS_PENDING] : $frontMap[$status] ?? $frontMap[self::STATUS_PENDING];

        return [
            'key' => $status,
            'filter_key' => $status === self::STATUS_CONFIRMED ? self::STATUS_ACCEPTED_ORDERS : $status,
            'text' => $payload['label'],
            'label' => $payload['label'],
            'class' => $payload['class'],
        ];
    }

    private function applyPendingFilter(Builder $query, ?int $providerId = null): Builder
    {
        return $this->applyNonScheduledConstraint($query)
            ->where(function ($builder) use ($providerId) {
                $builder->where(function ($inner) {
                    $inner->whereDoesntHave('timeline')
                        ->orWhereHas('timeline', function ($timelineQuery) {
                            $timelineQuery->where('timeline_no', 1);
                        });
                });
            })
            ->whereDoesntHave('timeline', function ($builder) {
                $builder->whereIn('timeline_no', [2, 3, 4, 5, 6, 12]);
            })
            ->whereDoesntHave('offers', function ($builder) use ($providerId) {
                $this->applyProviderOfferScope($builder, $providerId);
                $builder->whereIn('status', [2, '2', 'accepted', 3, '3', 'rejected']);
            });
    }

    private function applyConfirmedFilter(Builder $query, ?int $providerId = null): Builder
    {
        return $this->applyNonScheduledConstraint($query)
            ->whereDoesntHave('timeline', function ($builder) {
                $builder->whereIn('timeline_no', [3, 4, 5, 6, 12]);
            })
            ->where(function ($builder) use ($providerId) {
                $builder->whereHas('timeline', function ($timelineQuery) {
                    $timelineQuery->where('timeline_no', 2);
                })->orWhere(function ($offersQuery) use ($providerId) {
                    $offersQuery->whereHas('offers', function ($builder) use ($providerId) {
                        $this->applyProviderOfferScope($builder, $providerId);
                        $builder->whereIn('status', [2, '2', 'accepted']);
                    });
                });
            });
    }

    private function applyProcessingFilter(Builder $query, ?int $providerId = null): Builder
    {
        return $this->applyNonScheduledConstraint($query)
            ->whereDoesntHave('timeline', function ($builder) {
                $builder->whereIn('timeline_no', [6, 12]);
            })
            ->where(function ($builder) use ($providerId) {
                $builder->whereHas('timeline', function ($timelineQuery) {
                    $timelineQuery->whereIn('timeline_no', [3, 4, 5, 7, 9]);
                })->orWhere(function ($acceptedOffers) use ($providerId) {
                    $acceptedOffers->whereHas('offers', function ($offerQuery) use ($providerId) {
                        $this->applyProviderOfferScope($offerQuery, $providerId);
                        $offerQuery->whereIn('status', [2, '2', 'accepted']);
                    })->whereHas('timeline', function ($timelineQuery) {
                        $timelineQuery->whereIn('timeline_no', [7, 9]);
                    });
                });
            });
    }

    private function applyCompletedFilter(Builder $query): Builder
    {
        return $this->applyNonScheduledConstraint($query)
            ->whereHas('timeline', function ($builder) {
                $builder->where('timeline_no', 6);
            });
    }

    private function applyScheduledFilter(Builder $query, ?int $providerId = null): Builder
    {
        return $query
            ->where('request_type', 2)
            ->whereDoesntHave('timeline', function ($builder) {
                $builder->where('timeline_no', 12);
            })
            ->where(function ($builder) use ($providerId) {
                $builder->where(function ($scheduledBuilder) {
                    $scheduledBuilder->whereNull('schedule_start_date')
                        ->orWhereDate('schedule_start_date', '>', now()->toDateString());
                })->orWhere(function ($offersBuilder) use ($providerId) {
                    $offersBuilder->whereDoesntHave('offers', function ($offerQuery) use ($providerId) {
                        $this->applyProviderOfferScope($offerQuery, $providerId);
                        $offerQuery->whereIn('status', [2, '2', 'accepted']);
                    });
                });
            })
            ->whereDoesntHave('timeline', function ($builder) {
                $builder->where('timeline_no', 6);
            });
    }

    private function applyActiveScheduledFilter(Builder $query, ?int $providerId = null): Builder
    {
        return $query
            ->where('request_type', 2)
            ->whereDate('schedule_start_date', '<=', now()->toDateString())
            ->whereHas('offers', function ($builder) use ($providerId) {
                $this->applyProviderOfferScope($builder, $providerId);
                $builder->whereIn('status', [2, '2', 'accepted']);
            })
            ->whereDoesntHave('timeline', function ($builder) {
                $builder->whereIn('timeline_no', [6, 12]);
            });
    }

    private function applyCompletedScheduledFilter(Builder $query, ?int $providerId = null): Builder
    {
        return $query
            ->where('request_type', 2)
            ->whereHas('offers', function ($builder) use ($providerId) {
                $this->applyProviderOfferScope($builder, $providerId);
                $builder->whereIn('status', [2, '2', 'accepted']);
            })
            ->whereHas('timeline', function ($builder) {
                $builder->where('timeline_no', 6);
            });
    }

    private function applyCancelledFilter(Builder $query): Builder
    {
        return $query->whereHas('timeline', function ($builder) {
            $builder->where('timeline_no', 12);
        });
    }

    private function applyRejectedFilter(Builder $query, ?int $providerId = null): Builder
    {
        return $this->applyNonScheduledConstraint($query)
            ->whereDoesntHave('timeline', function ($builder) {
                $builder->where('timeline_no', 12);
            })
            ->whereHas('offers', function ($builder) use ($providerId) {
                $this->applyProviderOfferScope($builder, $providerId);
                $builder->whereIn('status', [3, '3', 'rejected']);
            })
            ->whereDoesntHave('offers', function ($builder) use ($providerId) {
                $this->applyProviderOfferScope($builder, $providerId);
                $builder->whereIn('status', [2, '2', 'accepted']);
            })
            ->when(!$providerId, function ($builder) {
                $builder->whereDoesntHave('offers', function ($offerQuery) {
                    $offerQuery->whereIn('status', [1, '1', 'pending']);
                });
            });
    }

    private function resolveOfferStatus($offers, ?int $providerId = null): string
    {
        $filteredOffers = $offers->when($providerId, function ($collection) use ($providerId) {
            return $collection->where('provider_id', $providerId);
        });

        if ($filteredOffers->contains(fn ($offer) => $this->normalizeOfferStatus($offer->status) === 'accepted')) {
            return 'accepted';
        }

        if ($filteredOffers->contains(fn ($offer) => $this->normalizeOfferStatus($offer->status) === 'rejected')) {
            return 'rejected';
        }

        return 'pending';
    }

    private function normalizeOfferStatus($status): string
    {
        return match ((string) $status) {
            '2', 'accepted' => 'accepted',
            '3', 'rejected' => 'rejected',
            default => 'pending',
        };
    }

    private function scheduleHasStarted(Order $order): bool
    {
        if (!$order->schedule_start_date) {
            return false;
        }

        return Carbon::parse($order->schedule_start_date)->startOfDay()->lte(now()->startOfDay());
    }

    private function isProcessingTimeline(int $timelineNo): bool
    {
        return in_array($timelineNo, [3, 4, 5, 7, 9], true);
    }

    private function isConfirmedTimeline(int $timelineNo): bool
    {
        return $timelineNo === 2;
    }

    private function applyProviderOfferScope(Builder $query, ?int $providerId = null): void
    {
        if ($providerId) {
            $query->where('provider_id', $providerId);
        }
    }

    private function applyNonScheduledConstraint(Builder $query): Builder
    {
        return $query->where(function ($builder) {
            $builder->where('request_type', '!=', 2)
                ->orWhereNull('request_type');
        });
    }
}
