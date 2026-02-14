<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\CouponRepository;
use App\Http\Requests\Admin\CouponRequests\CouponStoreRequest;
use App\Http\Requests\Admin\CouponRequests\CouponUpdateRequest;

class CouponController extends Controller
{

    public $coupons;

    public function __construct(CouponRepository $coupons)
    {
        $this->coupons = $coupons;
    }

    public function index($offset, $limit)
    {
        try{
            $coupons = $this->coupons->index($offset, $limit);
            return view('admin.coupons.index', compact('coupons'));
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(CouponStoreRequest $request)
    {
        try{
            $this->coupons->store($request);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function edit($id)
    {
        $coupon = $this->coupons->findOne($id);
        return view('admin.coupons.update', compact('coupon'));
    }

    public function update(CouponUpdateRequest $request, $id)
    {
        try{
            $this->coupons->update($request, $id);
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
            $this->coupons->activate($request->record_id);
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
            $this->coupons->delete($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->coupons->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->coupons->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->coupons->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        $coupons = $this->coupons->archives($offset, $limit);
        return view('admin.coupons.archives', compact('coupons'));
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->coupons->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->coupons->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->coupons->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->coupons->back($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

}