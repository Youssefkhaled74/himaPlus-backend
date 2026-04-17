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

    public function index($offset, $limit, $tab = 'orders', $orderNo = '')
    {
        return $this->pagination($offset, $limit, $tab, $orderNo);
    }

    public function pagination($offset, $limit, $tab = 'orders', $orderNo = '')
    {
        return $this->model
            ->with(array_merge($this->model->model_relations(), ['timeline', 'offers']))
            ->withCount($this->model->model_relations_counts())
            ->unArchive()
            ->when($orderNo !== '' && ctype_digit($orderNo), function ($query) use ($orderNo) {
                $query->where('id', (int) $orderNo);
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
            ->paginate(PAGINATION_COUNT);
    }

    public function create(){}

    public function edit($id){}

    public function archivesPage($offset, $limit){}

}
