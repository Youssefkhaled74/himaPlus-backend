<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\RatingRepository;
use App\Http\Requests\Admin\RatingRequests\RatingStoreRequest;
use App\Http\Requests\Admin\RatingRequests\RatingUpdateRequest;

class RatingController extends Controller
{

    public $ratings;

    public function __construct(RatingRepository $ratings)
    {
        $this->ratings = $ratings;
    }

    public function index($offset, $limit)
    {
        try{
            return $this->ratings->index($offset, $limit);
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function create()
    {
        return $this->ratings->create();
    }

    public function store(RatingStoreRequest $request)
    {
        try{
            $this->ratings->store($request);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function edit($id)
    {
        return $this->ratings->edit($id);
    }

    public function update(RatingUpdateRequest $request, $id)
    {
        try{
            $this->ratings->update($request, $id);
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
            $this->ratings->activate($request->record_id);
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
            $this->ratings->delete($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->ratings->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->ratings->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->ratings->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        return $this->ratings->archivesPage($offset, $limit);
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->ratings->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->ratings->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->ratings->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->ratings->back($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

}