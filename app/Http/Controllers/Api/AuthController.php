<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\UserRepository;
use App\Http\ServicesLayer\ForJawalyServices\ForJawalyService;
use App\Jobs\SendSmsJob;
use App\Jobs\SendUserCodeMailJob;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCodeMail;
use App\Traits\PushNotificationsTrait;

class AuthController extends Controller
{

    use PushNotificationsTrait;
    
    public $user;
    public $notification;
    public $userRepository;
    public $forJawalyService;
    
    public function __construct(
        User $user, Notification $notification, UserRepository $userRepository, ForJawalyService $forJawalyService
    ){
        $this->user = $user;
        $this->notification = $notification;
        $this->userRepository = $userRepository;
        $this->forJawalyService = $forJawalyService;
        $this->middleware('auth:api', ['except' => ['checkToken', 'login', 'register', 'mobileCheck', 'regenerateCode', 'sendResetCodePassword', 'verifyResetCodePassword', 'resetPassword', 'changePassword']]);
    }
    
    public function checkToken()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (is_null($user)) {
                return responseJson(200, "success", false);
            }else {
                return responseJson(200, "success", true);
            }
        } catch (\Throwable $th) {
            return responseJson(200, "success", false);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:254|unique:users,name',
            'email' => 'required|string|max:254|unique:users,email',
            'mobile' => 'required|string|max:254|unique:users,mobile',
            'iban' => 'nullable|string|max:254|unique:users,iban',
            'password' => 'required|confirmed|max:30',
            
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'user_type' => 'required|in:1,2,3',
            
            'branch' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'cr_number' => 'nullable|string|max:255',
            'cr_file_document' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf',

            'fcm_token' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        try {

            DB::beginTransaction();
            $user = $this->userRepository->store($request);
            $user->update([
                // 'code' => 1111,
                'code' => rand(1000, 9999),
            ]);
            $this->notification->create([
                'title' => 'verified your account',
                'content' => "your code: #$user->code",
                'user_id' => $user->id,
            ]);
            DB::commit();               
        } catch (\Exception $e) {
            DB::rollback();
            return responseJson(500, 'there is some thing wrong , please contact technical support');
        }

        // try {
        //     Mail::to($user->email)->send(new UserCodeMail($user->code));
        //     $this->forJawalyService->sendSMS($user->mobile, $user->code);
        //     dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        //     dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());
        // } catch (\Exception $e) { dd($e); }
        
        // dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());
        if (!is_null($user->fcm_token)) {
            $this->targetFairbaseServicePushNotification(
                $user->fcm_token, "verified your account", "your code: #$user->code", 0, 0
            );
        }

        return responseJson(200, "success");
    }

    public function mobileCheck(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:users,code|max:4',
            'email' => 'required|exists:users,email|max:100|min:6',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        try {
            $user = $this->user->where('email', $request->email)->where('code', $request->code)->with(['cart.product', 'favorites.product'])->first();
            if(!is_null($user->deleted_at)){
                return responseJson(401, "This Account Not Activate , Please Contact Technical Support");
            }
            DB::beginTransaction();
            $user->update([
                'code' => null,
                'mobile_verified_at' =>  now(),
                'email_verified_at' =>  now(),
            ]);
            $user->token = JWTAuth::customClaims(['exp' => Carbon::now()->addYears(20)->timestamp])->fromUser($user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return responseJson(500, "Internal Server Error");
        }
        // except
        return responseJson(200, "success", $user->makeHidden(['password', 'code']));
    }

    public function regenerateCode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email|max:100|min:6',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }

        $user = $this->user->where('email', $request->email)->first();
        if(!is_null($user->deleted_at)){
            return responseJson(401, "This Account Not Activate , Please Contact Technical Support");
        }
        try {

            DB::beginTransaction();
            $user->update([
                // 'code' => 1111,
                'code' => rand(1000, 9999),
                'mobile_verified_at' =>  null,
                'email_verified_at' =>  null,
            ]);
            $this->notification->create([
                'title' => 'verified your account',
                'content' => "your code: #$user->code",
                'user_id' => $user->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return responseJson(500, "Internal Server Error");
        }

        // dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());
        if (!is_null($user->fcm_token)) {
            $this->targetFairbaseServicePushNotification(
                $user->fcm_token, "verified your account", "your code: #$user->code", 0, 0
            );
        }

        return responseJson(200, "success");
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|exists:users,email|max:100|min:6',
                'password' => 'required',

                'fcm_token' => 'nullable|string',
            ]);
            if ($validator->fails()) {
                return responseJson(400, "Bad Request", $validator->errors()->first());
            }

            $user = $this->user->where('email', $request->email)->with(['cart.product', 'favorites.product'])->first();
            if(!$user || !is_null($user->deleted_at) || (int)$user->is_activate == 0){
                return responseJson(401, "هذا الحساب غير مفعل برجاء الاتصال بالاداره");
            }
            if(is_null($user->mobile_verified_at) && is_null($user->email_verified_at)){
                return responseJson(401, "هذا الحساب غير مؤكد برجاء تاكيد الايميل او رقم الجوال");
            }
            if(!FacadesHash::check($request->password, $user->password)){
                return response()->json(['error' => 'خطا في الايميل او الرقم السري'], 401);
            }

            if (isset($request->fcm_token) && !is_null($request->fcm_token)) {
                $user->update([
                    'fcm_token' => $request->fcm_token ?? null,
                ]);
            }
            $user->token = JWTAuth::customClaims(['exp' => Carbon::now()->addYears(20)->timestamp])->fromUser($user);
            return responseJson(200, "success", $user->makeHidden(['password', 'code']));
        } catch (\Exception $e) {
            return responseJson(500, "Internal Server Error {$e}");
        }
    }
    
    public function me()
    {
        return responseJson(200, "success", auth()->user()->makeHidden(['password', 'code'])->load(['cart.product', 'favorites.product']));
    }
    
    public function cart()
    {
        $cart = auth()->user()->cart()->with('product')->orderByDesc('id')->get();
        return responseJson(200, "success", $cart);
    }
    
    public function favorites($offset, $limit)
    {
        $favorites = auth()->user()->favorites()->with('product')->orderByDesc('id')->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, "success", $favorites);
    }
    
    public function notifications($offset, $limit)
    {
        $notifications = auth()->user()->notifications()->with('serviceable')->orderByDesc('id')->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, "success", $notifications);
    }

    public function userUpdate(Request $request)
    {

        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:254|unique:users,name,' . $user->id,
            'email' => 'required|string|max:254|unique:users,email,' . $user->id,
            'iban' => 'required|string|max:254|unique:users,iban,' . $user->id,
            
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'branch' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'cr_number' => 'nullable|string|max:255',
            'cr_file_document' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        $user = $this->userRepository->customUpdate($request, $user->id);
        return responseJson(200, "success", $user->makeHidden(['password', 'code']));
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',  
            'new_password' => 'required|max:30|confirmed',  
        ]);

        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }

        $user = auth()->guard('api')->user();

        if (!$user) {
            return responseJson(401, "Unauthorized: User not logged in.");
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return responseJson(400, "Old password is incorrect.");
        }

        try {
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);
        } catch (\Exception $e) {
            return responseJson(500, "Internal Server Error", $e->getMessage());
        }

        return responseJson(200, "Password changed successfully.");
    }

    // this function => "mobileCheck" after this step 
    public function changeMobileNum(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:users,mobile|max:100|min:6'
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
  
        $user = auth()->user(); 
        try {

            DB::beginTransaction();
            $user->update([
                'mobile' => $request->mobile,
                'mobile_verified_at' =>  null,
                'email_verified_at' =>  null,
                // 'code' => 1111,
                'code' => rand(1000, 9999),
            ]);
            $this->notification->create([
                'title' => 'verified your account',
                'content' => "your code: #$user->code",
                'user_id' => $user->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return responseJson(500, "Internal Server Error");
        }

        // dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());

        return responseJson(200, "success");
    }

    public function logout()
    {
        auth()->logout();
        $data['token'] = null;
        return responseJson(200, "successfully logged out", $data);
    }

    public function refresh()
    {
        return responseJson(200, "success", auth()->refresh());
    }
    
    public function sendResetCodePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:100|min:6',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }

        $user = $this->user->where('email', $request->email)->first();
        if (!$user) {
            return responseJson(404, "User not found");
        }

        try {
            // $user->update(['code' => 1111]);
            $user->update(['code' => rand(1000, 9999)]);
            $this->notification->create([
                'title' => 'verified your account',
                'content' => "your code: #$user->code",
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            return responseJson(500, "Internal Server Error");
        }

        // dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());

        return responseJson(200, "Reset code sent successfully.");
    }

    public function verifyResetCodePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email|max:100|min:6',
            'code' => 'required|exists:users,code|max:4',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }

        $user = $this->user->where('email', $request->email)->first();
        if (!$user || !is_null($user->deleted_at) || $user->code != $request->code) {
            return responseJson(401, "There Is Something Wrong, Please Contact Technical Support");
        }

        return responseJson(200, "Code verified successfully.");
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email|max:100|min:6',
            'code' => 'required|exists:users,code|max:4',
            'password' => 'required|confirmed|max:30',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }

        $user = $this->user->where('email', $request->email)->first();
        if (!$user || !is_null($user->deleted_at) || $user->code != $request->code) {
            return responseJson(401, "This Account Not Activated, Please Contact Technical Support");
        }

        try {
            $user->update([
                'password' => bcrypt($request->password),
                'code' => null, 
            ]);
        } catch (\Exception $e) {
            return responseJson(500, "Internal Server Error");
        }
        return responseJson(200, "Password reset successfully.");
    }

}