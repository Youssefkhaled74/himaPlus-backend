<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    public $product;

    public function __construct(Product $product){
        $this->product = $product;
        $this->middleware('auth:api', ['except' => []]);
    }

    public function toggleInCart(Request $request, $id)
    {
        try{
            $record = $this->product->where('id', $id)->first();
            if ($record && !is_null($record)) {
                $item = auth()->user()->cart()->firstOrNew(['product_id' => $id]);
                if ($item->exists) {
                    $item->delete();
                    return responseJson(200, "success");
                }
                $item->quantity = (int)$request->input('quantity', 1);
                $item->save();
                return responseJson(200, "success");
            }
            return responseJson(500, 'product not found , please contact technical support');
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

    public function addToCart(Request $request, $id)
    {
        try{
            $record = $this->product->where('id', $id)->first();
            if ($record && !is_null($record)) {
                auth()->user()->cart()->updateOrCreate(
                    ['product_id' => $id],
                    ['quantity'   => $request->quantity ?? 1]
                );
                return responseJson(200, "success");
            }
            return responseJson(500, 'product not found , please contact technical support');
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

    public function removeFromCart($id)
    {
        try{
            auth()->user()->cart()->where('product_id', $id)->delete();
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

    public function removeAll()
    {
        try{
            auth()->user()->cart()->delete();
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

    public function updateQuantity(Request $request, $id)
    {
        try{
            $cartItem = auth()->user()->cart()->where('product_id', $id)->first();
            if ($cartItem) {
                if ($request->type == 'plus') {
                    $cartItem->update([
                        'quantity' => (int)$cartItem->quantity + 1,
                    ]);
                    return responseJson(200, "success");
                }else if ($request->type == 'negative') {
                    if ((int)$cartItem->quantity > 1) {
                        $cartItem->update([
                            'quantity' => (int)$cartItem->quantity - 1,
                        ]);
                    } else {
                        $cartItem->delete();
                    }
                    return responseJson(200, "success");
                }
            }
            return responseJson(500, 'product not found , please contact technical support');
        }catch(\Exception $e){
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }
    }

}
