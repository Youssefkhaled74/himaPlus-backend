<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Coupon;
use App\Http\Repositories\Eloquent\Admin\BaseAdminRepository;

class CouponRepository extends BaseAdminRepository
{

    protected $model;

    public function __construct(Coupon $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'coupons';
    }

    public function index($offset, $limit, $search = '')
    {
        return $this->pagination($offset, $limit, $search);
    }

    public function pagination($offset, $limit, $search = '')
    {
        return $this->model
            ->with($this->model->model_relations())
            ->withCount($this->model->model_relations_counts())
            ->unArchive()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('id', 'LIKE', "%{$search}%");
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
