<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\OrderRepository;
use App\Http\Requests\Admin\OrderRequests\OrderStoreRequest;
use App\Http\Requests\Admin\OrderRequests\OrderUpdateRequest;

class OrderController extends Controller
{

    public $orders;

    public function __construct(OrderRepository $orders)
    {
        $this->orders = $orders;
    }

    public function index($offset, $limit)
    {
        try{
            $orders = $this->orders->index($offset, $limit);
            return view('admin.orders.index', compact('orders'));
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
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
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function edit($id)
    {
        $order = $this->orders->findOne($id);
        return view('admin.orders.update', compact('order'));
    }

    public function update(OrderUpdateRequest $request, $id)
    {
        try{
            $this->orders->update($request, $id);
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
            $this->orders->activate($request->record_id);
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
            $this->orders->delete($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
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
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

}