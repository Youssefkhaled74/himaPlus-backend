<?php

namespace App\Http\Controllers\Front;

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
    }

    public function rating(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|in:0,1,2,3,4,5', 
                'comment' => 'nullable|string|max:10000', 
                'for_id' => 'required|integer', 
                'for_type' => 'required|string|in:User,Product', 
            ]);
            if ($validator->fails()) {
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
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
            flash()->success("success");
            return back();
        } catch (\Exception $ex) {
            flash()->error("there is something wrong , please contact technical support");
            return back();
        }
    }

}
