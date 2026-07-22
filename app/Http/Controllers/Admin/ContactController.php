<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\ContactRepository;
use App\Http\Requests\Admin\ContactRequests\ContactStoreRequest;
use App\Http\Requests\Admin\ContactRequests\ContactUpdateRequest;

class ContactController extends Controller
{

    public $contacts;

    public function __construct(ContactRepository $contacts)
    {
        $this->contacts = $contacts;
    }

    public function index(Request $request, $offset, $limit)
    {
        try{
            $search = (string) $request->get('search', '');
            $contacts = $this->contacts->index($offset, $limit, $search);
            return view('admin.contacts.index', compact('contacts', 'search'));
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(ContactStoreRequest $request)
    {
        try{
            $this->contacts->store($request);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function edit($id)
    {
        $contact = $this->contacts->findOne($id);
        return view('admin.contacts.update', compact('contact'));
    }

    public function update(ContactUpdateRequest $request, $id)
    {
        try{
            $this->contacts->update($request, $id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function activate(Request $request)
    {
        try{
            $this->contacts->activate($request->record_id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function delete(Request $request)
    {
        try{
            $this->contacts->delete($request->record_id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->contacts->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->contacts->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->contacts->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        $contacts = $this->contacts->archives($offset, $limit);
        return view('admin.contacts.archives', compact('contacts'));
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->contacts->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->contacts->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->contacts->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->contacts->back($request->record_id);
            flash()->success(__('messages.success'));
            return back();
        }catch(\Exception $e){
            flash()->error(__('messages.something_went_wrong'));
            return back();
        }
    }

}