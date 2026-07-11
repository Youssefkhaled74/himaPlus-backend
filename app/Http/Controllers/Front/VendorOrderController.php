<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Offer;
use App\Services\OrderStatusService;
use App\Services\VendorOrderVisibilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VendorOrderController extends Controller
{
    public function __construct(
        private OrderStatusService $orderStatusService,
        private VendorOrderVisibilityService $vendorOrderVisibilityService
    )
    {
    }

    private function normalizeOfferStatus($status): string
    {
        if ((string) $status === '2' || $status === 2 || $status === 'accepted') {
            return 'accepted';
        }

        if ((string) $status === '3' || $status === 3 || $status === 'rejected') {
            return 'rejected';
        }

        return 'pending';
    }

    private function offerStatusToDbValues(?string $status): ?array
    {
        if (!$status) {
            return null;
        }

        return match (strtolower($status)) {
            'accepted' => [2, '2', 'accepted'],
            'rejected' => [3, '3', 'rejected'],
            default => [1, '1', 'pending'],
        };
    }

    /**
     * Display list of orders received by vendor
     */
    public function index(Request $request)
    {
        $vendor = auth()->user();
        $tab = $request->get('tab', 'all');
        $status = $request->get('status', '');
        $search = $request->get('search', '');
        
        $query = $this->vendorOrderVisibilityService
            ->visibleOrdersQuery((int) $vendor->id, $tab)
            ->with(['user:id,name,email,mobile', 'items.product', 'offers', 'timeline']);
        
        if ($status) {
            $this->orderStatusService->applyStatusFilter($query, $status, [
                'audience' => 'front',
                'provider_id' => (int) $vendor->id,
            ]);
        }
        
        if ($search) {
            $query->where('id', 'LIKE', '%' . $search . '%');
        }
        
        $orders = $query->latest()
            ->paginate(15)
            ->through(function ($order) use ($vendor) {
                $order->front_status_state = $order->resolveStatus([
                    'audience' => 'front',
                    'provider_id' => (int) $vendor->id,
                ]);

                return $order;
            });
        
        $myOffersCount = Offer::where('provider_id', $vendor->id)->count();
        
        // Get counts for tabs
        $counts = [
            'all' => $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'all')->count(),
            'purchase' => $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'purchase')->count(),
            'quotations' => $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'quotations')->count(),
            'maintenance' => $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'maintenance')->count(),
            'scheduled' => $this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, 'scheduled')->count(),
            'confirmed' => $this->orderStatusService->countByStatus($this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, $tab), OrderStatusService::STATUS_CONFIRMED, ['provider_id' => (int) $vendor->id]),
            'processing' => $this->orderStatusService->countByStatus($this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, $tab), OrderStatusService::STATUS_PROCESSING, ['provider_id' => (int) $vendor->id]),
            'completed' => $this->orderStatusService->countByStatus($this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, $tab), OrderStatusService::STATUS_COMPLETED, ['provider_id' => (int) $vendor->id]),
            'scheduled_status' => $this->orderStatusService->countByStatus($this->vendorOrderVisibilityService->visibleOrdersQuery((int) $vendor->id, $tab), OrderStatusService::STATUS_SCHEDULED, ['provider_id' => (int) $vendor->id]),
        ];
        
        return view('front.vendor.orders.index', compact('orders', 'tab', 'status', 'search', 'myOffersCount', 'counts'));
    }

    /**
     * Show order details
     */
    public function show($id)
    {
        $vendor = auth()->user();
        $order = Order::where('id', $id)
            ->with(['user', 'items.product', 'timeline', 'offers.provider'])
            ->firstOrFail();

        $isAllowed = $this->vendorOrderVisibilityService->canViewOrder($order, (int) $vendor->id);

        if (!$isAllowed) {
            abort(403);
        }
        
        $myOffer = Offer::where('order_id', $id)
            ->where('provider_id', $vendor->id)
            ->first();
        
        $order->front_status_state = $order->resolveStatus([
            'audience' => 'front',
            'provider_id' => (int) $vendor->id,
        ]);

        return view('front.vendor.orders.show', compact('order', 'myOffer'));
    }

    /**
     * Show offer creation form
     */
    public function offerForm($orderId)
    {
        $order = Order::with('user')->find($orderId);
        if (!$order) {
            abort(404);
        }
        
        $vendor = auth()->user();
        
        // Check if vendor already made an offer
        $existingOffer = Offer::where('order_id', $orderId)
            ->where('provider_id', $vendor->id)
            ->first();
        
        if ($existingOffer) {
            flash()->warning('لقد قدمت عرضاً لهذا الطلب بالفعل');
            return redirect()->route('vendor/orders/show', $orderId);
        }
        
        return view('front.vendor.orders.offer-form', compact('order'));
    }

    /**
     * Store offer
     */
    public function makeOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'price' => 'required|numeric|min:0',
            'delivery_days' => 'required|integer|min:1',
            'warranty' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $vendor = auth()->user();
            $order = Order::find($request->order_id);
            
            if (!$order) {
                flash()->error('الطلب غير موجود');
                return back();
            }
            
            // Check if offer already exists
            $offer = Offer::where('order_id', $request->order_id)
                ->where('provider_id', $vendor->id)
                ->first();
            
            if ($offer) {
                // Update existing offer
                $offer->update([
                    'cost' => $request->price,
                    'delivery_time' => $request->delivery_days,
                    'warranty' => $request->warranty,
                    'notes' => $request->notes,
                ]);
            } else {
                // Create new offer
                $offer = Offer::create([
                    'order_id' => $request->order_id,
                    'provider_id' => $vendor->id,
                    'cost' => $request->price,
                    'delivery_time' => $request->delivery_days,
                    'warranty' => $request->warranty,
                    'notes' => $request->notes,
                    'status' => 1,
                ]);
            }
            
            // Handle file upload
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('offers', 'public');
                $offer->update(['files' => 'storage/' . $path]);
            }
            
            DB::commit();
            flash()->success('تم تقديم العرض بنجاح');
            return redirect()->route('vendor/orders/my-offers');
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error('حدث خطأ أثناء تقديم العرض: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Display vendor's offers
     */
    public function myOffers(Request $request)
    {
        $vendor = auth()->user();
        $status = $request->get('status', '');
        $search = $request->get('search', '');
        
        $baseQuery = Offer::where('provider_id', $vendor->id)
            ->whereNull('deleted_at');

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->whereIn('status', [1, '1', 'pending'])->count(),
            'accepted' => (clone $baseQuery)->whereIn('status', [2, '2', 'accepted'])->count(),
            'rejected' => (clone $baseQuery)->whereIn('status', [3, '3', 'rejected'])->count(),
        ];

        $query = (clone $baseQuery);
        
        if ($status) {
            $statusValues = $this->offerStatusToDbValues($status);
            if ($statusValues) {
                $query->whereIn('status', $statusValues);
            }
        }

        if ($search) {
            $query->where(function ($builder) use ($search) {
                $builder->where('order_id', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        
        $offers = $query->with(['order:id,order_type,request_type,user_id', 'order.user:id,name,email'])
            ->latest()
            ->paginate(15);
        
        $offers->getCollection()->transform(function ($offer) {
            $offer->status_label = $this->normalizeOfferStatus($offer->status);
            return $offer;
        });

        return view('front.vendor.orders.my-offers', compact('offers', 'status', 'search', 'counts'));
    }

    /**
     * Edit offer
     */
    public function editOffer($offerId)
    {
        $vendor = auth()->user();
        $offer = Offer::where('id', $offerId)
            ->where('provider_id', $vendor->id)
            ->with('order')
            ->firstOrFail();
        
        return view('front.vendor.orders.offer-edit', compact('offer'));
    }

    /**
     * Update offer
     */
    public function updateOffer(Request $request, $offerId)
    {
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric|min:0',
            'delivery_days' => 'required|integer|min:1',
            'warranty' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $vendor = auth()->user();
            $offer = Offer::where('id', $offerId)
                ->where('provider_id', $vendor->id)
                ->firstOrFail();
            
            $offer->update([
                'cost' => $request->price,
                'delivery_time' => $request->delivery_days,
                'warranty' => $request->warranty,
                'notes' => $request->notes,
            ]);
            
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('offers', 'public');
                $offer->update(['files' => 'storage/' . $path]);
            } elseif ($request->filled('remove_attachment')) {
                $offer->update(['files' => null]);
            }
            
            flash()->success('تم تحديث العرض بنجاح');
            return redirect()->route('vendor/orders/my-offers');
        } catch (\Exception $e) {
            flash()->error('حدث خطأ أثناء تحديث العرض');
            return back();
        }
    }

    /**
     * Delete offer
     */
    public function deleteOffer($offerId)
    {
        $vendor = auth()->user();
        $offer = Offer::where('id', $offerId)
            ->where('provider_id', $vendor->id)
            ->firstOrFail();
        
        $offer->delete();
        flash()->success('تم حذف العرض بنجاح');
        return redirect()->route('vendor/orders/my-offers');
    }
}
