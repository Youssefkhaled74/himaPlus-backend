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
use Illuminate\Support\Facades\Auth as FacadesAuth;

class VendorAuthController extends Controller
{
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
    }
    
    /**
     * Show vendor registration form
     */
    public function registerForm()
    {
        if (auth()->check() && auth()->user()->user_type == 2) {
            return redirect()->route('vendor/dashboard');
        }
        return view('front.vendor.auth.register');
    }

    /**
     * Store new vendor account
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:254|unique:users,name',
            'email' => 'required|string|max:254|unique:users,email',
            'mobile' => 'required|string|max:254|unique:users,mobile',
            'password' => 'required|confirmed|max:30',
            'iban' => 'required|string|max:254|unique:users,iban',
            'branch' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'cr_number' => 'required|string|max:255',
            'cr_file_document' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,webm',
            'terms' => 'required|in:1',
            'fcm_token' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Merge user_type as vendor (2)
            $request->merge(['user_type' => 2]);
            $user = $this->userRepository->store($request);
            
            // Generate verification code
            $user->update([
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
            flash()->error('There is something wrong, please contact technical support');
            return back();
        }

        // Send verification email
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());

        flash()->success("Registration successful. Please verify your account.");
        return redirect(route('vendor/account-check/form', $user->id));
    }

    /**
     * Show account verification form
     */
    public function accountCheckForm($id)
    {
        $user = $this->user->where('id', $id)->where('user_type', 2)->first();
        if (is_null($user)) {
            flash()->error("Invalid verification link. Please contact technical support.");
            return redirect(route('vendor/login'));
        }
        return view('front.vendor.auth.accountCheck', compact('user'));
    }

    /**
     * Verify account with code
     */
    public function accountCheck(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:users,code|max:4',
        ]);
        
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        
        try {
            $user = $this->user->where('id', $id)->where('code', $request->code)->where('user_type', 2)->first();
            
            if(is_null($user) || !is_null($user->deleted_at)){
                flash()->error("Invalid verification code or account not found");
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
                flash()->success("Account verified successfully");
                return redirect(route('vendor/dashboard'));
            }
            
            DB::rollback();
            flash()->error("Something went wrong. Please try again.");
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            flash()->error("Internal Server Error");
            return back();
        }
    }

    /**
     * Regenerate verification code
     */
    public function regenerateCode(Request $request, $id)
    {
        $user = $this->user->where('id', $id)->where('user_type', 2)->first();
        
        if(is_null($user) || !is_null($user->deleted_at)){
            flash()->error("Account not found or deactivated");
            return back();
        }
        
        try {
            DB::beginTransaction();
            $user->update([
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
        
        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());
        
        flash()->success("Verification code sent successfully");
        return back();
    }

    /**
     * Show vendor login form
     */
    public function loginForm()
    {
        if (auth()->check() && auth()->user()->user_type == 2) {
            return redirect()->route('vendor/dashboard');
        }
        return view('front.vendor.auth.login');
    }

    /**
     * Authenticate vendor login
     */
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

            $user = $this->user->where('email', $request->email)->where('user_type', 2)->first();
            
            if(!$user || !is_null($user->deleted_at) || (int)$user->is_activate == 0){
                flash()->error("This account is not activated. Please contact support.");
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }
            
            if(is_null($user->mobile_verified_at) && is_null($user->email_verified_at)){
                flash()->error("This account is not verified. Please verify your email or mobile number.");
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }
            
            if(!Hash::check($request->password, $user->password)){
                flash()->error('Invalid email or password');
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }

            if(FacadesAuth::guard('web')->attempt($request->only('email', 'password'))){
                return redirect(route('vendor/dashboard'));
            }else{
                flash()->error("Login failed. Please try again.");
                return back();
            }
        } catch (\Exception $e) {
            flash()->error("Internal Server Error");
            return back();
        }
    }

    /**
     * Show vendor profile
     */
    public function profile()
    {
        return view('front.vendor.auth.profile');
    }

    /**
     * Update vendor profile
     */
    public function userUpdate(Request $request)
    {
        $user = auth()->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:254|unique:users,name,' . $user->id,
            'email' => 'required|string|max:254|unique:users,email,' . $user->id,
            'mobile' => 'required|string|max:254|unique:users,mobile,' . $user->id,
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,webm',
            'location' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:254|unique:users,iban,' . $user->id,
            'tax_number' => 'nullable|string|max:255',
            'cr_number' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }

        try {
            $prepared = $this->userRepository->handle_request($request);
            
            if (($prepared['email'] ?? $user->email) !== $user->email) {
                $prepared['email_verified_at'] = null;
            }
            if (($prepared['mobile'] ?? $user->mobile) !== $user->mobile) {
                $prepared['mobile_verified_at'] = null;
            }
            
            $updateData = [
                'name' => $prepared['name'] ?? $user->name,
                'email' => $prepared['email'] ?? $user->email,
                'mobile' => $prepared['mobile'] ?? $user->mobile,
                'location' => $prepared['location'] ?? $user->location,
                'branch' => $prepared['branch'] ?? $user->branch,
                'iban' => $prepared['iban'] ?? $user->iban,
                'tax_number' => $prepared['tax_number'] ?? $user->tax_number,
                'cr_number' => $prepared['cr_number'] ?? $user->cr_number,
            ];
            
            if (isset($prepared['img'])) {
                $updateData['img'] = $prepared['img'];
            }
            if (isset($prepared['email_verified_at'])) {
                $updateData['email_verified_at'] = $prepared['email_verified_at'];
            }
            if (isset($prepared['mobile_verified_at'])) {
                $updateData['mobile_verified_at'] = $prepared['mobile_verified_at'];
            }
            
            $user->update($updateData);
            flash()->success('Profile updated successfully');
            return back();
        } catch (\Exception $e) {
            flash()->error('Failed to update profile: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Update vendor language preference
     */
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
        flash()->success('Language updated successfully');
        return back();
    }

    /**
     * Change vendor password
     */
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
            flash()->success('Password changed successfully');
            return back();
        } catch (\Exception $e) {
            flash()->error("Failed to change password");
            return back();
        }
    }

    /**
     * Show password reset code form
     */
    public function sendResetCodePasswordForm(Request $request)
    {
        return view('front.vendor.auth.sendResetCode');
    }

    /**
     * Send password reset code
     */
    public function sendResetCodePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|max:100|min:6',
        ]);
        
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        
        $user = $this->user->where('user_type', 2)->where(function ($q) use ($request) {
            $q->where('mobile', $request->data)->orWhere('email', $request->data);
        })->first();
        
        if (!$user) {
            flash()->error("Vendor account not found");
            return back();
        }

        try {
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

        dispatch(new SendUserCodeMailJob($user->email, (string) $user->code))->delay(now()->addMinute());

        flash()->success("Reset code sent successfully.");
        return redirect(route('vendor/reset-password/form', $user->id));
    }

    /**
     * Show password reset form
     */
    public function resetPasswordForm(Request $request, $id)
    {
        $user = $this->user->where('id', $id)->where('user_type', 2)->first();
        
        if (!$user || !is_null($user->deleted_at)) {
            flash()->error("This account is not activated. Please contact technical support.");
            return redirect(route('vendor/login'));
        }
        
        return view('front.vendor.auth.resetPasswordForm', compact('id'));
    }

    /**
     * Reset vendor password
     */
    public function resetPassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:users,code|max:4',
            'password' => 'required|confirmed|max:30',
        ]);
        
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }

        $user = $this->user->where('id', $id)->where('user_type', 2)->first();
        
        if (!$user || !is_null($user->deleted_at) || $user->code != $request->code) {
            flash()->error("Invalid reset code or account not found");
            return back();
        }
        
        try {
            $user->update([
                'password' => bcrypt($request->password),
                'code' => null, 
            ]);
            flash()->success("Password reset successfully.");
            return redirect()->to(route('vendor/login'));
        } catch (\Exception $e) {
            flash()->error("Internal Server Error");
            return back();
        }
    }

    /**
     * Logout vendor
     */
    public function logout()
    {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        flash()->success('Logged out successfully');
        return redirect(route('vendor/login'));
    }
}
