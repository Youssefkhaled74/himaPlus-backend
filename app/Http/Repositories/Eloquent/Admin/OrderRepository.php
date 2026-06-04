<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Order;
use App\Http\Repositories\Eloquent\Admin\BaseAdminRepository;

class OrderRepository extends BaseAdminRepository
{

    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'orders';
    }

    public function index($offset, $limit, $tab = 'orders', $orderNo = '', $status = '', $orderType = '', $paymentStatus = '', $dateFrom = '', $dateTo = '')
    {
        return $this->pagination($offset, $limit, $tab, $orderNo, $status, $orderType, $paymentStatus, $dateFrom, $dateTo);
    }

    public function pagination($offset, $limit, $tab = 'orders', $orderNo = '', $status = '', $orderType = '', $paymentStatus = '', $dateFrom = '', $dateTo = '')
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
                $timelineMap = [
                    'confirmed' => 2,
                    'processing' => 3,
                    'shipped' => 4,
                    'delivered' => 5,
                    'completed' => 6,
                    'offers_received' => 7,
                    'supplier_selected' => 8,
                    'converted_to_order' => 9,
                    'under_review' => 10,
                    'assigned_to_supplier' => 11,
                    'canceled' => 12,
                ];
                if ($status === 'pending') {
                    $query->whereDoesntHave('timeline');
                } elseif ($status === 'scheduled') {
                    $query->where('request_type', 2);
                } elseif ($status === 'offers_pending') {
                    $query->whereHas('offers', function ($q) {
                        $q->whereIn('status', [1, '1', 'pending']);
                    });
                } elseif ($status === 'accepted') {
                    $query->whereHas('offers', function ($q) {
                        $q->whereIn('status', [2, '2', 'accepted']);
                    });
                } elseif (isset($timelineMap[$status])) {
                    $query->whereHas('timeline', function ($q) use ($timelineMap, $status) {
                        $q->where('timeline_no', $timelineMap[$status]);
                    })->whereDoesntHave('timeline', function ($q) use ($timelineMap, $status) {
                        $q->where('timeline_no', '>', $timelineMap[$status]);
                    });
                }
            })
            ->when($tab === 'requests', function ($query) {
                $query->whereIn('order_type', [2, 3])
                    ->whereNull('offer_id');
            }, function ($query) {
                $query->where(function ($businessQuery) {
                    $businessQuery->where('order_type', 1)
                        ->orWhereNotNull('offer_id');
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT)
            ->appends(request()->query());
    }

    public function create(){}

    public function edit($id){}

    public function archivesPage($offset, $limit){}

}
