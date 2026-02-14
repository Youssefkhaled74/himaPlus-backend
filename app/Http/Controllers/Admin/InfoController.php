<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\InfoRepository;
use App\Http\Requests\Admin\InfoRequests\InfoStoreRequest;
use App\Http\Requests\Admin\InfoRequests\InfoUpdateRequest;

class InfoController extends Controller
{

    public $info;

    public function __construct(InfoRepository $info)
    {
        $this->info = $info;
    }

    public function index($offset, $limit)
    {
        try{
            return $this->info->index($offset, $limit);
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function create()
    {
        return $this->info->create();
    }

    public function store(InfoStoreRequest $request)
    {
        try{
            $this->info->store($request);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function edit($id)
    {
        return $this->info->edit($id);
    }

    public function update(InfoUpdateRequest $request, $id)
    {
        try{
            $this->info->update($request, $id);
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
            $this->info->activate($request->record_id);
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
            $this->info->delete($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->info->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->info->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->info->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        return $this->info->archivesPage($offset, $limit);
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->info->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->info->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->info->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->info->back($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

}