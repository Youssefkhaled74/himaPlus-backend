<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{

    public $product;

    public function __construct(Product $product){
        $this->product = $product;
        $this->middleware('auth:api', ['except' => []]);
    }

    public function toggleInFavorites($id)
    {
        try{
            $record = $this->product->where('id', $id)->first();
            if ($record && !is_null($record)) {
                $item = auth()->user()->favorites()->firstOrNew(['product_id' => $id]);
                if ($item->exists) {
                    $item->delete();
                    return responseJson(200, "success");
                }
                $item->save();
                return responseJson(200, "success");
            }
            return responseJson(500, 'product not found , please contact technical support');
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

    public function removeFromFavorites($id)
    {
        try{
            auth()->user()->favorites()->where('product_id', $id)->delete();
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

    public function removeAll()
    {
        try{
            auth()->user()->favorites()->delete();
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

}
