<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class VendorNotificationsController extends Controller
{
    /**
     * Display notifications list
     */
    public function index(Request $request)
    {
        $vendorId = auth()->id();
        
        // Build query for notifications
        $query = Notification::where('user_id', $vendorId)
            ->orderBy('created_at', 'desc');
        
        // Filter by type if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        // Filter by read status
        $filter = $request->get('filter', 'all');
        if ($filter == 'unread') {
            $query->unread();
        } elseif ($filter == 'read') {
            $query->read();
        }
        
        $notifications = $query->paginate(15);
        
        // Get counts for filters
        $counts = [
            'total' => Notification::where('user_id', $vendorId)->count(),
            'unread' => Notification::where('user_id', $vendorId)->unread()->count(),
            'orders' => Notification::where('user_id', $vendorId)->where('type', 'order')->count(),
            'offers' => Notification::where('user_id', $vendorId)->where('type', 'offer')->count(),
            'scheduled' => Notification::where('user_id', $vendorId)->where('type', 'scheduled')->count(),
            'rating' => Notification::where('user_id', $vendorId)->where('type', 'rating')->count(),
        ];
        
        return view('front.vendor.notifications.index', [
            'notifications' => $notifications,
            'counts' => $counts,
            'filter' => $filter,
        ]);
    }
    
    /**
     * Mark notification as read
     */
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
    
    /**
     * Delete notification
     */
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
    
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $vendorId = auth()->id();
        
        Notification::where('user_id', $vendorId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        flash()->success(__('messages.all_marked'));
        return back();
    }
}
