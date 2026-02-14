<?php

namespace App\Http\Controllers\Api;

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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{

    public $user;
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
        Product $product
    )
    {
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
        $this->middleware('auth:api', ['except' => ['home', 'test', 'info', 'providers', 'countries', 'categories', 'ratings']]);
    }

    public function home(Request $request)
    {
        $data['ratings'] = $this->funSearch($request, 0, $this->rating->active()->unArchive());
        $data['categories'] = $this->funSearch($request, 0, $this->category->active()->unArchive());
        $data['offers'] = $this->funSearch($request, 0, $this->product->active()->unArchive()->isOffer());
        $data['featured'] = $this->funSearch($request, 0, $this->product->active()->unArchive()->isSpecial());
        return responseJson(200, "success", $data);
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

    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'location' => 'nullable|string|max:1255',
            'details' => 'nullable|string|max:1255',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }

        $this->contact->create([
            'mobile' => $request->mobile,
            'email' => $request->email,
            'location' => $request->location,
            'details' => $request->details,
        ]);
        return responseJson(200, "success");
    }
    
    public function providers(Request $request, $offset, $limit)
    {
        $data = $this->funSearch($request, $offset, $this->user->getProviders()->active()->unArchive());
        return responseJson(200, "success", $data);
    }
    
    public function categories(Request $request, $offset, $limit)
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
            $builderFillter = $builder->latest()->with($relations)->withCount($relationsCount);
            if (isset($request->all) && (int)$request->get('all') == 1) {
                $records = $builderFillter->get(); 
            }else {
                $records = $builderFillter->offset($offset)->limit(PAGINATION_COUNT)->get(); 
            }
        }        
        return $records;
    }

}
