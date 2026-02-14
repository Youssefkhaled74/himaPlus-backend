<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Product;
use DevxPackage\AbstractRepository;

class ProductRepository extends AbstractRepository
{

    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'products';
    }

    public function index($offset, $limit)
    {
        return $this->pagination($offset, $limit);
    }

    public function pagination($offset, $limit)
    {
        return $this->model->with($this->model->model_relations())->withCount($this->model->model_relations_counts())->unArchive()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
    }

    public function update($request, $id)
    {
        $request = $this->handle_request($request);
        $request['weight'] = $request['weight'] ?? null;
        $request['warranty'] = $request['warranty'] ?? null;
        $request['origin_id'] = $request['origin_id'] ?? null;
        $request['dimensions'] = $request['dimensions'] ?? null;
        $request['expiry_date'] = $request['expiry_date'] ?? null;
        $request['imaging_type'] = $request['imaging_type'] ?? null;
        $request['power'] = $request['power'] ?? null;
        $request['stock_quantity'] = $request['stock_quantity'] ?? null;
        $request['production_date'] = $request['production_date'] ?? null;
        $request['manufacture_date'] = $request['manufacture_date'] ?? null;
        $request['is_offer'] = isset($request['is_offer']) ? 1 : 0;
        $request['is_special'] = isset($request['is_special']) ? 1 : 0;
        return $this->model->where("id", $id)->update($request);
    }

    public function create(){}

    public function edit($id){}

    public function archivesPage($offset, $limit){}

}