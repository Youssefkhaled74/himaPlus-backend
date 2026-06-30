<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Product;
use App\Http\Repositories\Eloquent\Admin\BaseAdminRepository;

class ProductRepository extends BaseAdminRepository
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

    public function index($offset, $limit, $search = '', $lowStock = '')
    {
        return $this->pagination($offset, $limit, $search, $lowStock);
    }

    public function pagination($offset, $limit, $search = '', $lowStock = '')
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
            ->when($lowStock !== '', function ($query) {
                $query->lowStock();
            })
            ->orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT)
            ->appends(request()->query());
    }

    public function update($request, $id)
    {
        $request = $this->handle_request($request);
        $request['weight'] = $request['weight'] ?? null;
        $request['warranty'] = $request['warranty'] ?? null;
        $request['origin_id'] = $request['origin_id'] ?? null;
        $request['registration_type'] = $request['registration_type'] ?? null;
        $request['guarantee_file'] = $request['guarantee_file'] ?? $this->model->find($id)?->guarantee_file;
        $request['registration_number'] = $request['registration_number'] ?? null;
        $request['registration_expiry_date'] = $request['registration_expiry_date'] ?? null;
        $request['factory_name'] = $request['factory_name'] ?? null;
        $request['factory_country'] = $request['factory_country'] ?? null;
        $request['uom'] = $request['uom'] ?? null;
        $request['expiry_date'] = $request['expiry_date'] ?? null;
        $request['power'] = $request['power'] ?? null;
        $request['stock_quantity'] = $request['stock_quantity'] ?? null;
        $request['production_date'] = $request['production_date'] ?? null;
        $request['manufacture_date'] = $request['manufacture_date'] ?? null;
        $request['is_offer'] = isset($request['is_offer']) ? 1 : 0;
        $request['is_special'] = isset($request['is_special']) ? 1 : 0;
        return $this->model->where("id", $id)->update($request);
    }

    public function handle_request($request)
    {
        if ($request->hasFile('file')) {
            $file = uploadIamge($request->file('file'), $this->crudName());
            $request->merge(['img' => $file]);
        }
        if ($request->hasFile('files')) {
            $files = uploadIamges($request->file('files'), $this->crudName());
            $request->merge(['imgs' => $files]);
        }
        if ($request->hasFile('guarantee_file')) {
            $file = uploadIamge($request->file('guarantee_file'), $this->crudName());
            $request->merge(['guarantee_file' => $file]);
        }
        if ($request->hasFile('product_pdf')) {
            $file = uploadIamge($request->file('product_pdf'), $this->crudName());
            $request->merge(['product_pdf' => $file]);
        }

        return array_filter(array_intersect_key($request->all(), $this->model->fildes()));
    }

    public function create(){}

    public function edit($id){}

    public function archivesPage($offset, $limit){}

}
