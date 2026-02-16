<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\UserRepository;
use App\Http\ServicesLayer\ForJawalyServices\ForJawalyService;
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
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Models\Favorite;
use App\Models\Report;

class AuthController extends Controller
{
    public $user;
    public $report;
    public $favorite;
    public $notification;
    public $userRepository;
    public $forJawalyService;
    
    public function __construct(
        User $user, Report $report, Favorite $favorite, Notification $notification, UserRepository $userRepository, ForJawalyService $forJawalyService
    ){
        $this->user = $user;
        $this->report = $report;
        $this->favorite = $favorite;
        $this->notification = $notification;
        $this->userRepository = $userRepository;
        $this->forJawalyService = $forJawalyService;
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:254|unique:users,name',
            'email' => 'required|string|max:254|unique:users,email',
            'mobile' => 'required|string|max:254|unique:users,mobile',
            'password' => 'required|confirmed|max:30',
            'user_type' => 'required|in:1,2',
            'iban' => 'required_if:user_type,2|string|max:254|unique:users,iban',
            
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,webm',
            
            'branch' => 'required_if:user_type,2|string|max:255',
            'location' => 'required_if:user_type,2|string|max:255',
            'tax_number' => 'required_if:user_type,2|string|max:255',
            'cr_number' => 'required_if:user_type,2|string|max:255',
            'cr_file_document' => 'required_if:user_type,2|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:5120',

            'terms' => 'nullable|in:1',
            'fcm_token' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        try {

            DB::beginTransaction();
            $request->merge(['user_type' => (int) $request->user_type]);
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
            flash()->error('there is some thing wrong , please contact technical support');
            return back();
        }

        // try {
        //     Mail::to($user->email)->send(new UserCodeMail($user->code));
        //     $this->forJawalyService->sendSMS($user->mobile, $user->code);
        //     dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        //     dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());
        // } catch (\Exception $e) { dd($e); }
        
        // dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());

        flash()->success("success");
        return redirect(route('user/account-check/form', $user->id));
    }
    
    public function accountCheckForm($id)
    {
        $user = $this->user->where('id', $id)->first();
        if (is_null($user)) {
            flash()->error("there is spmething wrong , please contact technical support");
            return back();
        }
        return view('front.auth.login.accountCheck', compact('user'));
    }

    public function accountCheck(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:users,code|max:4',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        try {
            $user = $this->user->where('id', $id)->where('code', $request->code)->with(['cart.product', 'favorites.product'])->first();
            if(!is_null($user->deleted_at)){
                flash()->error("This Account Not Activate , Please Contact Technical Support");
                return back();
            }
            DB::beginTransaction();
            $user->update([
                'code' => null,
                'mobile_verified_at' =>  now(),
                'email_verified_at' =>  now(),
            ]);
            
            FacadesAuth::guard('web')->login($user);
            if ($request->session()->regenerate()) {
                DB::commit();
                flash()->success("success");
                if ((int) $user->user_type === 2) {
                    return redirect(route('vendor/dashboard'));
                }
                return redirect(route('user/profile'));
            }else{
                // flash()->error("There IS Something Worng");
                // return back();
            }

            dd('credentials', $user);
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error("Internal Server Error");
            return back();
        }
    }

    public function regenerateCode(Request $request, $id)
    {

        // $validator = Validator::make($request->all(), [
        //     'email' => 'nullable|exists:users,email|max:100|min:6',
        //     'mobile' => 'nullable|exists:users,mobile|max:100|min:6',
        // ]);
        // if ($validator->fails()) {
        //     return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        // }

        $user = $this->user->where('id', $id)->first();
        if(!is_null($user->deleted_at)){
            flash()->error("This Account Not Activate , Please Contact Technical Support");
            return back();
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
            flash()->error("Internal Server Error");
            return back();
        }
        
        // dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());
        
        flash()->success("success");
        return back();
    }

    public function loginForm()
    {
        if (auth()->check()) {
            if ((int) auth()->user()->user_type === 2) {
                return redirect()->route('vendor/dashboard');
            }
            return redirect()->route('user/profile');
        }
        return view('front.auth.login.login');
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|exists:users,email|max:100|min:6',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }

            $user = $this->user->where('email', $request->email)->with(['cart.product', 'favorites.product'])->first();
            if(!$user || !is_null($user->deleted_at) || (int)$user->is_activate == 0){
                flash()->error("هذا الحساب غير مفعل برجاء الاتصال بالاداره");
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }
            if(is_null($user->mobile_verified_at) && is_null($user->email_verified_at)){
                flash()->error("هذا الحساب غير مؤكد برجاء تاكيد الايميل او رقم الجوال");
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }
            if(!FacadesHash::check($request->password, $user->password)){
                flash()->error('خطا في الايميل او الرقم السري');
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }

            if(FacadesAuth::guard('web')->attempt($request->only('email', 'password'))){
                $loggedInUser = auth()->user();
                if ($loggedInUser && (int) $loggedInUser->user_type === 2) {
                    return redirect(route('vendor/dashboard'));
                }
                return redirect(route('user/profile'));
            }else{
                flash()->error("There IS Something Worng");
                return back();
            }
        } catch (\Exception $e) {
            flash()->error("Internal Server Error");
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
    }

    public function profile()
    {
        return view('front.auth.profile');
    }
    
    public function cart()
    {
        $cart = auth()->user()->cart()->with(['product' => fn($q) => $q->with(['category'])])->orderByDesc('id')->get();
        return view('front.auth.cart', compact('cart'));
    }
    
    public function favorites()
    {
        $report = $this->report->first();
        $favorites = $this->favorite->where('user_id', auth()->user()->id)->with([
            'product' => function ($q){
                $q->with(['category', 'is_favorite'])->withAvg('ratings', 'rating');
            }
        ])->orderByDesc('id')->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('front.auth.favorites', compact(['report', 'favorites']));
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
            'mobile' => 'required|string|max:254|unique:users,mobile,' . $user->id,
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,webm',
            'location' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }

        $request = $this->userRepository->handle_request($request);
        if (!$request['email'] == $user->email) {
            $request['email_verified_at'] = null;
        }
        if (!$request['mobile'] == $user->mobile) {
            $request['mobile_verified_at'] = null;
        }
        $request['name'] = $request['name'];
        $request['email'] = $request['email'];
        $request['mobile'] = $request['mobile'];
        $request['location'] = isset($request['location']) ? $request['location'] : $user->location;

        $user->update($request);
        flash()->success('success');
        return back();
    }

    public function userLang(Request $request)
    {

        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'lang' => 'required|string|in:en,ar',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        $user->update([
            'lang' => $request->lang
        ]);
        session()->put('locale', $request->lang);
        flash()->success('success');
        return back();
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',  
            'password' => 'required|max:30|confirmed',  
        ]);
        
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        if (!$user) {
            flash()->error("Unauthorized: User not logged in.");
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        if (!Hash::check($request->old_password, $user->password)) {
            flash()->error("Old password is incorrect.");
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }

        try {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        } catch (\Exception $e) {
            flash()->error("Internal Server Error");
            return back();
        }

        flash()->success('success');
        return back();
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
        flash()->success('success');
        return back();
    }

    public function refresh()
    {
        return responseJson(200, "success", auth()->refresh());
    }
    
    public function sendResetCodePasswordForm(Request $request)
    {
        return view('front.auth.login.sendResetCode');
    }
    
    public function sendResetCodePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|max:100|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        
        $user = $this->user->where('mobile', $request->data)->orWhere('email', $request->data)->first();
        if (!$user) {
            flash()->error("User not found");
            return back();
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
            flash()->error("Internal Server Error");
            return back();
        }

        // dispatch(new SendSmsJob($user->mobile, (string) $user->code))->delay(now()->addMinute());
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());

        flash()->success("Reset code sent successfully.");
        return redirect(route('user/reset-password/form', $user->id));
    }

    public function resetPasswordForm(Request $request, $id)
    {
        $user = $this->user->where('id', $id)->first();
        if (!$user || !is_null($user->deleted_at)) {
            flash()->error(401, "This Account Not Activated, Please Contact Technical Support");
            return back();
        }
        return view('front.auth.login.resetPasswordForm', compact('id'));
    }

    public function resetPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:users,code|max:4',
            'password' => 'required|confirmed|max:30',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }

        $user = $this->user->where('id', $id)->first();
        if (!$user || !is_null($user->deleted_at) || $user->code != $request->code) {
            flash()->error("This Account Not Activated, Please Contact Technical Support");
            return back();
        }
        try {
            $user->update([
                'password' => bcrypt($request->password),
                'code' => null, 
            ]);
        } catch (\Exception $e) {
            flash()->error("Internal Server Error");
            return back();
        }

        flash()->success("Password reset successfully.");
        return redirect()->to(route('user/loginForm'));
    }

}
