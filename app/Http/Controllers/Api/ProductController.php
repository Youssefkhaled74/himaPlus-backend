<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Repositories\Eloquent\Admin\ProductRepository;
use App\Http\Requests\Admin\ProductRequests\ProductStoreRequest;

class ProductController extends Controller
{

    public $product;
    public $productRepository;

    public function __construct(
        Product $product, ProductRepository $productRepository
    ){
        $this->product = $product;
        $this->productRepository = $productRepository;
        $this->middleware('auth:api', ['except' => ['products', 'details']]);
    }

    public function products(Request $request, $offset, $limit)
    {
        try{
            $records = $this->product
            ->when($request->price_from && $request->price_to, function($q) use($request) {
                $q->whereBetween('price', [$request->price_from, $request->price_to]);
            })
            ->when($request->price_from && !$request->price_to, function($q) use($request) {
                $q->where('price', '>=', $request->price_from);
            })
            ->when(!$request->price_from && $request->price_to, function($q) use($request) {
                $q->where('price', '<=', $request->price_to);
            })
            ->when($request->category_id, function($q) use($request) {
                $q->where('category_id', $request->category_id);
            })
            ->when($request->provider_id, function($q) use($request) {
                $q->where('provider_id', $request->provider_id);
            })
            ->when($request->is_offer, function($q) {
                $q->where('is_offer', 1);
            })
            ->when($request->is_special, function($q) {
                $q->where('is_special', 1);
            })
            ->when($request->get('q'), function($q) use($request) {
                $q->whereAny(['id', 'name', 'desc'], 'like', '%'. $request->get('q') .'%');
            })
            ->when($request->sort , function($q) use($request) {
                if ((int)$request->sort == 1) { $q->orderBy('id', 'ASC'); } 
                elseif ((int)$request->sort == 2) { $q->orderBy('id', 'DESC'); } 
                elseif ((int)$request->sort == 3) { $q->orderBy('price', 'ASC'); } 
                elseif ((int)$request->sort == 4) { $q->orderBy('price', 'DESC'); } 
                elseif ((int)$request->sort == 5) { $q->withCount('order_item')->orderBy('order_item_count', 'DESC'); } 
                else { $q->orderBy('id', 'DESC'); }
            })
            ->active()->unArchive()->with('category')->withCount(['ratings'])->withAvg('ratings', 'rating')
            ->offset($offset)->limit(PAGINATION_COUNT)->get();
            return responseJson(200, "success", $records);
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }
    
    public function details($id)
    {
        $record = $this->product->where('id', $id)->with([
            'provider', 'category', 'origin', 'ratings.user'
        ])->withCount(['ratings'])->withAvg('ratings', 'rating')->first();
        return responseJson(200, "success", $record);
    }
    
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name'           => ['required', 'string', 'min:2', 'unique:products,name', 'max:255'],
                'category_id'    => ['required', 'integer', 'exists:categories,id'],
                'desc'           => ['required', 'string', 'max:1255'],
                'price'          => ['required', 'numeric', 'min:0', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
                'stock_quantity' => ['nullable', 'integer', 'min:0'],

                'file'            => ['required', 'file', 'mimes:jpeg,png,jpg,webp,webm,avif', 'max:5120'],
                'files'           => ['nullable', 'array', 'max:10'],
                'files.*'         => ['file', 'mimes:jpeg,png,jpg,webp,webm,avif', 'max:5120'],

                'imaging_type'     => ['nullable', 'string', 'max:255'],
                'manufacture_date' => ['nullable', 'date', 'before_or_equal:today'],
                'production_date'  => ['nullable', 'date', 'before_or_equal:today'],
                'expiry_date'      => ['nullable', 'date', 'after:manufacture_date'],
                'weight'        => ['nullable', 'string', 'max:255'],
                'dimensions'    => ['nullable', 'string', 'max:255'],
                'warranty'      => ['nullable', 'string', 'max:255'],
                'origin_id'     => ['nullable', 'integer', 'exists:countries,id'],
                'is_offer'     => ['nullable', 'in:1,0'],
                'is_special'     => ['nullable', 'in:1,0'],
            ]);
            if ($validator->fails()) {
                return responseJson(400, "Bad Request", $validator->errors()->first());
            }
            $request->merge(['provider_id' => auth()->user()->id]);
            $this->productRepository->store($request);
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }
    
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name'           => ["required", "string", "min:2", "unique:products,name,$id","max:255"],
                'category_id'    => ['required', 'integer', 'exists:categories,id'],
                'desc'           => ['required', 'string', 'max:1255'],
                'price'          => ['required', 'numeric', 'min:0', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
                'stock_quantity' => ['nullable', 'integer', 'min:0'],

                'file'            => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,webm,avif', 'max:5120'],
                'files'           => ['nullable', 'array', 'max:10'],
                'files.*'         => ['file', 'mimes:jpeg,png,jpg,webp,webm,avif', 'max:5120'],

                'imaging_type'     => ['nullable', 'string', 'max:255'],
                'manufacture_date' => ['nullable', 'date', 'before_or_equal:today'],
                'production_date'  => ['nullable', 'date', 'before_or_equal:today'],
                'expiry_date'      => ['nullable', 'date', 'after:manufacture_date'],
                'weight'        => ['nullable', 'string', 'max:255'],
                'dimensions'    => ['nullable', 'string', 'max:255'],
                'warranty'      => ['nullable', 'string', 'max:255'],
                'origin_id'     => ['nullable', 'integer', 'exists:countries,id'],
                'is_offer'     => ['nullable', 'in:1,0'],
                'is_special'     => ['nullable', 'in:1,0'],
            ]);
            if ($validator->fails()) {
                return responseJson(400, "Bad Request", $validator->errors()->first());
            }
            
            $record = $this->product->where('id', $id)->where('provider_id', auth()->user()->id)->first();
            if ($record && !is_null($record)) {
                $this->productRepository->update($request, $id);
            }
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }
    
    public function activate($id)
    {
        try{
            $record = $this->product->where('id', $id)->where('provider_id', auth()->user()->id)->first();
            if ($record && !is_null($record)) {
                $this->productRepository->activate($id);
            }
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

}
