<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\CategoryRepository;
use App\Http\Requests\Admin\CategoryRequests\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryRequests\CategoryUpdateRequest;

class CategoryController extends Controller
{

    public $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function index($offset, $limit)
    {
        try{
            $categories = $this->categories->index($offset, $limit);
            return view('admin.categories.index', compact('categories'));
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        try{
            $this->categories->store($request);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function edit($id)
    {
        $category = $this->categories->findOne($id);
        return view('admin.categories.update', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        try{
            $this->categories->update($request, $id);
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
            $this->categories->activate($request->record_id);
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
            $this->categories->delete($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->categories->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->categories->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->categories->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        $categories = $this->categories->archives($offset, $limit);
        return view('admin.categories.archives', compact('categories'));
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->categories->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->categories->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->categories->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->categories->back($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

}