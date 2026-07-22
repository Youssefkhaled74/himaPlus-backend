<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\OrderRepository;
use App\Http\Requests\Admin\OrderRequests\OrderStoreRequest;
use App\Http\Requests\Admin\OrderRequests\OrderUpdateRequest;
use App\Models\Order;

class OrderController extends Controller
{

    public $orders;

    public function __construct(OrderRepository $orders)
    {
        $this->orders = $orders;
    }

    public function index(Request $request, $offset, $limit)
    {
        try{
            $tab = (string) $request->get('tab', 'orders');
            $orderNo = trim((string) $request->get('order_no', ''));
            $status = (string) $request->get('status', '');
            $orderType = (string) $request->get('order_type', '');
            $paymentStatus = (string) $request->get('payment_status', '');
            $dateFrom = (string) $request->get('date_from', '');
            $dateTo = (string) $request->get('date_to', '');
            $scheduledStatus = (string) $request->get('scheduled_status', '');
            $orders = $this->orders->index($offset, $limit, $tab, $orderNo, $status, $orderType, $paymentStatus, $dateFrom, $dateTo, $scheduledStatus);
            return view('admin.orders.index', compact('orders', 'tab', 'orderNo', 'status', 'orderType', 'paymentStatus', 'dateFrom', 'dateTo', 'scheduledStatus'));
        }catch(\Exception $e){
            report($e);
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function store(OrderStoreRequest $request)
    {
        try{
            $this->orders->store($request);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Throwable $e){
            report($e);
            flash()->error($e->getMessage());
            return back();
        }
    }

    public function edit($id)
    {
        $order = Order::query()
            ->with([
                'user',
                'provider',
                'device_category',
                'coupon',
                'items.product',
                'timeline.user',
                'offers.provider',
                'offer.provider',
                'partial_receive',
            ])
            ->findOrFail($id);
        $order->admin_status_state = $order->resolveAdminStatus();

        return view('admin.orders.update', compact('order'));
    }

    public function update(OrderUpdateRequest $request, $id)
    {
        try{
            $this->orders->update($request, $id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function activate(Request $request)
    {
        try{
            $this->orders->activate($request->record_id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function delete(Request $request)
    {
        try{
            $this->orders->delete($request->record_id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->orders->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->orders->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->orders->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        $orders = $this->orders->archives($offset, $limit);
        return view('admin.orders.archives', compact('orders'));
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->orders->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->orders->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->orders->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->orders->back($request->record_id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

}
