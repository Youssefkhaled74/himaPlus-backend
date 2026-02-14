<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\ProductRepository;
use App\Http\Requests\Admin\ProductRequests\ProductStoreRequest;
use App\Http\Requests\Admin\ProductRequests\ProductUpdateRequest;

class ProductController extends Controller
{

    public $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    public function index($offset, $limit)
    {
        try{
            $products = $this->products->index($offset, $limit);
            return view('admin.products.index', compact('products'));
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductStoreRequest $request)
    {
        try{
            $this->products->store($request);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function edit($id)
    {
        $product = $this->products->findOne($id);
        return view('admin.products.update', compact('product'));
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        try{
            $this->products->update($request, $id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function activate(Request $request)
    {
        try{
            $this->products->activate($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function delete(Request $request)
    {
        try{
            $this->products->delete($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->products->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->products->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->products->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        $products = $this->products->archives($offset, $limit);
        return view('admin.products.archives', compact('products'));
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->products->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->products->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->products->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->products->back($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

}