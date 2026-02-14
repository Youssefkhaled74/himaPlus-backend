<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{

    public $rating;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
        $this->middleware('auth:api', ['except' => []]);
    }

    public function rating(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|in:0,1,2,3,4,5', 
            'comment' => 'nullable|string|max:10000', 
            'for_id' => 'required|integer', 
            'for_type' => 'required|string|in:User,Product', 
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        $user = auth()->user();
        $rating = $this->rating->create([
            'user_id' => $user->id, 
            'rating' => $request->rating, 
            'comment' => $request->comment, 
            'forable_id' => $request->for_id, 
            'forable_type' => "App\Models\\$request->for_type",
            'is_activate' => 0, 
        ]);
        return responseJson(200, "success");
    }

}
