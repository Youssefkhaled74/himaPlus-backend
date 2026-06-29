<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class VendorOrderVisibilityService
{
    public function visibleOrdersQuery(int $vendorId, string $tab = 'all'): Builder
    {
        $tab = $this->normalizeTab($tab);

        $query = Order::query()
            ->whereNull('deleted_at')
            ->where(function (Builder $builder) use ($vendorId) {
                $builder->where('provider_id', $vendorId)
                    ->orWhereHas('offers', function (Builder $offersQuery) use ($vendorId) {
                        $offersQuery->where('provider_id', $vendorId);
                    })
                    ->orWhere(function (Builder $publicRequestsQuery) {
                        $publicRequestsQuery->whereNull('provider_id')
                            ->where(function (Builder $typesQuery) {
                                $typesQuery->where('order_type', 2)
                                    ->orWhere('order_type', 3);
                            })
                            ->where(function (Builder $requestTypeQuery) {
                                $requestTypeQuery->where('request_type', 1)
                                    ->orWhereNull('request_type');
                            });
                    });
            });

        return $this->applyTabFilter($query, $tab);
    }

    public function canViewOrder(Order $order, int $vendorId): bool
    {
        if ((int) $order->provider_id === $vendorId) {
            return true;
        }

        $hasOffer = $order->relationLoaded('offers')
            ? $order->offers->contains(fn ($offer) => (int) $offer->provider_id === $vendorId)
            : $order->offers()->where('provider_id', $vendorId)->exists();

        if ($hasOffer) {
            return true;
        }

        return $this->isPublicRequest($order);
    }

    public function isPublicRequest(Order $order): bool
    {
        return empty($order->provider_id)
            && in_array((int) $order->order_type, [2, 3], true)
            && ((int) $order->request_type === 1 || $order->request_type === null);
    }

    private function applyTabFilter(Builder $query, string $tab): Builder
    {
        return match ($tab) {
            'purchase' => $query->purchaseOrders()->notScheduled(),
            'quotations' => $query->quotations()->notScheduled(),
            'maintenance' => $query->maintenance()->notScheduled(),
            'scheduled' => $query->scheduled(),
            default => $query,
        };
    }

    private function normalizeTab(string $tab): string
    {
        return in_array($tab, ['all', 'purchase', 'quotations', 'maintenance', 'scheduled'], true)
            ? $tab
            : 'all';
    }
}
