<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Order;
use App\Services\OrderStatusService;
use App\Http\Repositories\Eloquent\Admin\BaseAdminRepository;

class OrderRepository extends BaseAdminRepository
{

    protected $model;

    public function __construct(Order $model, protected OrderStatusService $orderStatusService)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'orders';
    }

    public function index($offset, $limit, $tab = 'orders', $orderNo = '', $status = '', $orderType = '', $paymentStatus = '', $dateFrom = '', $dateTo = '', $scheduledStatus = '')
    {
        return $this->pagination($offset, $limit, $tab, $orderNo, $status, $orderType, $paymentStatus, $dateFrom, $dateTo, $scheduledStatus);
    }

    public function pagination($offset, $limit, $tab = 'orders', $orderNo = '', $status = '', $orderType = '', $paymentStatus = '', $dateFrom = '', $dateTo = '', $scheduledStatus = '')
    {
        return $this->model
            ->with(array_merge($this->model->model_relations(), ['timeline', 'offers']))
            ->withCount($this->model->model_relations_counts())
            ->unArchive()
            ->when($orderNo !== '' && ctype_digit($orderNo), function ($query) use ($orderNo) {
                $query->where('id', (int) $orderNo);
            })
            ->when($orderType !== '', function ($query) use ($orderType) {
                $query->where('order_type', (int) $orderType);
            })
            ->when($paymentStatus !== '', function ($query) use ($paymentStatus) {
                $query->where('payment_status', (int) $paymentStatus);
            })
            ->when($dateFrom !== '', function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo !== '', function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($status !== '', function ($query) use ($status) {
                $this->orderStatusService->applyStatusFilter($query, $status, ['audience' => 'admin']);
            })
            ->when($scheduledStatus !== '', function ($query) use ($scheduledStatus) {
                $this->orderStatusService->applyStatusFilter($query, $scheduledStatus, ['audience' => 'admin']);
            })
            ->when($tab === 'requests', function ($query) {
                $query->whereIn('order_type', [2, 3])
                    ->whereNull('offer_id');
            })->when($tab === 'orders', function ($query) {
                $query->where(function ($businessQuery) {
                    $businessQuery->where('order_type', 1)
                        ->orWhereNotNull('offer_id');
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT)
            ->through(function ($order) {
                $order->admin_status_state = $order->resolveAdminStatus();

                return $order;
            })
            ->appends(request()->query());
    }

    public function create(){}

    public function edit($id){}

    public function archivesPage($offset, $limit){}

}
