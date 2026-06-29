<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VendorNotificationsController extends Controller
{
    private const ALLOWED_TYPES = [
        'order',
        'payment',
        'status_change',
        'product_approval',
        'product_rejection',
    ];

    public function index(Request $request)
    {
        $vendorId = auth()->id();

        $filter = $request->get('filter', 'all');
        if (!in_array($filter, ['all', 'unread', 'read'], true)) {
            $filter = 'all';
        }

        $selectedType = $request->get('type');
        if (!in_array($selectedType, self::ALLOWED_TYPES, true)) {
            $selectedType = null;
        }

        $query = $this->baseNotificationsQuery($vendorId)->orderByDesc('created_at');

        if ($selectedType) {
            $query->where('type', $selectedType);
        }

        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->read();
        }

        $notifications = $query->paginate(12)->appends($request->query());
        $notifications->getCollection()->transform(function (Notification $notification) {
            return $this->presentNotification($notification);
        });

        $baseQuery = $this->baseNotificationsQuery($vendorId);
        $counts = [
            'total' => (clone $baseQuery)->count(),
            'unread' => (clone $baseQuery)->unread()->count(),
            'read' => (clone $baseQuery)->read()->count(),
            'types' => collect(self::ALLOWED_TYPES)->mapWithKeys(function ($type) use ($vendorId) {
                return [$type => $this->baseNotificationsQuery($vendorId)->where('type', $type)->count()];
            })->all(),
        ];

        return view('front.vendor.notifications.index', [
            'notifications' => $notifications,
            'counts' => $counts,
            'filter' => $filter,
            'selectedType' => $selectedType,
            'typeOptions' => $this->typeOptions(),
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $vendorId = auth()->id();

        $notification = Notification::where('id', $id)
            ->where('user_id', $vendorId)
            ->first();

        if (!$notification) {
            flash()->error(__('messages.not_found', ['item' => 'Notification']));
            return back();
        }

        $notification->update(['read_at' => now()]);

        flash()->success(__('messages.notification_marked'));
        return back();
    }

    public function delete(Request $request, $id)
    {
        $vendorId = auth()->id();

        $notification = Notification::where('id', $id)
            ->where('user_id', $vendorId)
            ->first();

        if (!$notification) {
            flash()->error(__('messages.not_found', ['item' => 'Notification']));
            return back();
        }

        $notification->delete();

        flash()->success(__('messages.notification_deleted'));
        return back();
    }

    public function markAllAsRead(Request $request)
    {
        $vendorId = auth()->id();

        $this->baseNotificationsQuery($vendorId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        flash()->success(__('messages.all_marked'));
        return back();
    }

    private function baseNotificationsQuery(int $vendorId)
    {
        return Notification::query()
            ->where('user_id', $vendorId)
            ->whereIn('type', self::ALLOWED_TYPES);
    }

    private function presentNotification(Notification $notification): Notification
    {
        $type = in_array($notification->type, self::ALLOWED_TYPES, true) ? $notification->type : 'system';

        $notification->display_title = $notification->title ?: __('nav.notification');
        $notification->display_message = $notification->message ?: ($notification->content ?: '-');
        $notification->display_url = $notification->action_url ?: ($notification->order_id ? route('vendor/orders/show', $notification->order_id) : null);
        $notification->is_unread = is_null($notification->read_at);
        $notification->type_key = $type;
        $notification->type_label = $this->typeOptions()->get($type, __('nav.notification_system'));

        [$notification->icon, $notification->icon_class] = match ($type) {
            'order' => ['bi-receipt-cutoff', 'order'],
            'payment' => ['bi-credit-card-2-front', 'payment'],
            'status_change' => ['bi-arrow-repeat', 'status-change'],
            'product_approval' => ['bi-patch-check-fill', 'product-approval'],
            'product_rejection' => ['bi-patch-exclamation-fill', 'product-rejection'],
            default => ['bi-bell-fill', 'system'],
        };

        return $notification;
    }

    private function typeOptions(): Collection
    {
        return collect([
            'order' => __('nav.notification_order'),
            'payment' => __('nav.notification_payment'),
            'status_change' => __('nav.notification_status_change'),
            'product_approval' => __('nav.notification_product_approval'),
            'product_rejection' => __('nav.notification_product_rejection'),
        ]);
    }
}
