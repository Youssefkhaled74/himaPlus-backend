<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\Eloquent\Admin\UserRepository;
use App\Http\Requests\Admin\UserRequests\UserStoreRequest;
use App\Http\Requests\Admin\UserRequests\UserUpdateRequest;
use App\Models\Order;
use App\Models\Product;

class UserController extends Controller
{

    public $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index($offset, $limit)
    {
        try{
            $users = $this->users->index($offset, $limit);
            return view('admin.users.index', compact('users'));
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserStoreRequest $request)
    {
        try{
            $this->users->store($request);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function edit($id)
    {
        $user = $this->users->findOne($id);
        return view('admin.users.update', compact('user'));
    }

    public function show(Request $request, $id)
    {
        $user = $this->users->findOne($id);
        if (!$user) {
            abort(404);
        }

        $customerOrdersCount = Order::query()
            ->whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->count();

        $vendorOrdersCount = Order::query()
            ->whereNull('deleted_at')
            ->where('provider_id', $user->id)
            ->count();

        $productsCount = Product::query()
            ->whereNull('deleted_at')
            ->where('provider_id', $user->id)
            ->count();

        $customerOrders = Order::query()
            ->with(['provider:id,name', 'timeline', 'offers'])
            ->whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15, ['*'], 'customer_orders_page')
            ->appends($request->query());

        $vendorOrders = Order::query()
            ->with(['user:id,name', 'timeline', 'offers'])
            ->whereNull('deleted_at')
            ->where('provider_id', $user->id)
            ->latest()
            ->paginate(15, ['*'], 'vendor_orders_page')
            ->appends($request->query());

        $products = Product::query()
            ->with(['category:id,name'])
            ->whereNull('deleted_at')
            ->where('provider_id', $user->id)
            ->latest()
            ->paginate(15, ['*'], 'products_page')
            ->appends($request->query());

        $activeTab = $request->query('tab', 'account');

        return view('admin.users.show', compact(
            'user',
            'customerOrdersCount',
            'vendorOrdersCount',
            'productsCount',
            'customerOrders',
            'vendorOrders',
            'products',
            'activeTab'
        ));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try{
            $this->users->update($request, $id);
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
            $this->users->activate($request->record_id);
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
            $this->users->delete($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

    public function search(Request $request)
    {
        return $this->users->search($request);
    }

    public function searchByColumn(Request $request)
    {
        return $this->users->searchByColumn($request);
    }

    public function pagination($offset, $limit)
    {
        return $this->users->pagination($offset, $limit);
    }

    public function archives($offset, $limit)
    {
        $users = $this->users->archives($offset, $limit);
        return view('admin.users.archives', compact('users'));
    }

    public function archivesPagination($offset, $limit)
    {
        return $this->users->archives($offset, $limit);
    }

    public function archivesSearch(Request $request)
    {
        return $this->users->archivesSearch($request);
    }

    public function archivesSearchByColumn(Request $request)
    {
        return $this->users->archivesSearchByColumn($request);
    }


    public function back(Request $request)
    {
        try{
            $this->users->back($request->record_id);
            flash()->success('Success');
            return back();
        }catch(\Exception $e){
            flash()->error('There is something wrong , please contact technical support');
            return back();
        }
    }

}
