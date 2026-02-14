<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\CategoryRepository;
use App\Http\Repositories\Eloquent\Admin\CountryRepository;
use App\Http\Repositories\Eloquent\Admin\InfoRepository;
use App\Http\Repositories\Eloquent\Admin\UserRepository;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{

    public $user;
    public $report;
    public $product;
    public $category;
    public $country;
    public $contact;
    public $userRepository;
    public $infoRepository;
    public $countryRepository;
    public $categoryRepository;
    public $rating;

    public function __construct(
        User $user, UserRepository $userRepository, InfoRepository $infoRepository, CountryRepository $countryRepository,
        Contact $contact, Country $country, Category $category, CategoryRepository $categoryRepository, Rating $rating,
        Product $product, Report $report
    )
    {
        $this->report = $report;
        $this->user = $user;
        $this->product = $product;
        $this->category = $category;
        $this->country = $country;
        $this->contact = $contact;
        $this->userRepository = $userRepository;
        $this->infoRepository = $infoRepository;
        $this->countryRepository = $countryRepository;
        $this->categoryRepository = $categoryRepository;
        $this->rating = $rating;
    }

    public function home(Request $request)
    {
        session()->put('active_nav', 'home');
        $report = $this->report->with(['ratings.user', 'categories', 'featured' => fn($q) => $q->with('category')->withAvg('ratings', 'rating')])->first();
        return view('front.home', compact('report'));
    }

    public function aboutUs(Request $request)
    {
        session()->put('active_nav', 'about');
        $report = $this->report->first();
        return view('front.aboutUs', compact('report'));
    }

    public function contactUs(Request $request)
    {
        session()->put('active_nav', 'contact');
        $report = $this->report->first();
        return view('front.contactUs', compact('report'));
    }

    public function providersPage(Request $request)
    {
        session()->put('active_nav', 'contact');
        $report = $this->report->first();
        return view('front.providers', compact('report'));
    }

    public function categories(Request $request)
    {
        session()->put('active_nav', 'categories');
        $report = $this->report->with(['categories'])->first();
        return view('front.categories', compact('report'));
    }

    public function products(Request $request)
    {
        session()->put('active_nav', 'products');
        $report = $this->report->first();
        $products = $this->product->with(['category', 'is_favorite'])->active()->unArchive()->withAvg('ratings', 'rating')->paginate(PAGINATION_COUNT);
        return view('front.products', compact(['report', 'products']));
    }

    public function categoryProducts(Request $request, $id)
    {
        session()->put('active_nav', 'categories');
        $report = $this->report->with([
            'category' => fn($q) => $q->where('id', $id)->first()
        ])->first();
        $products = $this->product->where('category_id', $id)->active()->unArchive()->withAvg('ratings', 'rating')->paginate(PAGINATION_COUNT);
        return view('front.categoryProducts', compact('report', 'products'));
    }

    public function product(Request $request, $id)
    {
        session()->put('active_nav', 'categories');
        $report = $this->report->with([
            'category' => fn($q) => $q->where('id', $id)->first()
        ])->first();
        $product = $this->product->where('id', $id)->active()->unArchive()->with([
            'provider', 'origin', 'related_products' => fn($q) => $q->where('id', '!=', $id)->withAvg('ratings', 'rating'), 
            'top_rating.user', 'ratings'
        ])->withAvg('ratings', 'rating')->first();
        // dd($product);
        return view('front.product', compact('report', 'product'));
    }

    public function info()
    {
        $info = $this->infoRepository->getfirst();
        $info->abouts = array_values($info->abouts ?? []);
        $info->terms = array_values($info->terms ?? []);
        $info->privacy_policies = array_values($info->privacy_policies ?? []);
        return responseJson(200, "success", $info);
    }

    public function test(Request $request)
    {
        return $request->all();
    }

    public function storeContactUs(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'mobile' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'location' => 'nullable|string|max:1255',
                'details' => 'nullable|string|max:1255',
            ]);
            if ($validator->fails()) {
                return responseJson(400, "Bad Request", $validator->errors()->first());
            }
    
            $this->contact->create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'location' => $request->location,
                'details' => $request->details,
            ]);
            flash()->success("success");
            return back();
        } catch (\Exception $ex) {}
    }
    
    public function providers(Request $request, $offset = 0, $limit = 10)
    {
        $data = $this->funSearch($request, $offset, $this->user->getProviders()->active()->unArchive());
        return responseJson(200, "success", $data);
    }
    
    public function categoriesSearch(Request $request, $offset, $limit)
    {
        $data = $this->funSearch($request, $offset, $this->category->active()->unArchive());
        return responseJson(200, "success", $data);
    }
    
    public function ratings(Request $request, $offset, $limit)
    {
        $data = $this->funSearch($request, $offset, $this->rating->active()->unArchive());
        return responseJson(200, "success", $data);
    }
    
    public function countries(Request $request)
    {
        $data = $this->funSearch($request, 0, $this->country->active()->unArchive());
        return responseJson(200, "success", $data);
    }

    public function funSearch($request, $offset, Builder $builder)
    {
        $query = $request->get('q');
        $records = [];
        
        $model = $builder->getModel();
        $relations = method_exists($model, 'model_relations') ? $model->model_relations() : [];
        $relationsCount = method_exists($model, 'model_relations_counts') ? $model->model_relations_counts() : [];

        if( !is_null($query) ){
            $records = $builder->with($relations)->withCount($relationsCount)->modelSearch($query)->get();
        }else{
            $records = $builder->latest()->with($relations)->withCount($relationsCount)->offset($offset)->limit(PAGINATION_COUNT)->get(); 
        }        
        return $records;
    }

}
