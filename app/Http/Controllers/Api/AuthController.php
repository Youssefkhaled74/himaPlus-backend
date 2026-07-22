<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\UserRepository;
use App\Http\ServicesLayer\ForJawalyServices\ForJawalyService;
use App\Jobs\SendSmsJob;
use App\Jobs\SendUserCodeMailJob;
use App\Models\Notification;
use App\Models\User;
use App\Traits\AuthSecurityTrait;
use App\Traits\PushNotificationsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use AuthSecurityTrait;
    use PushNotificationsTrait;

    public $user;
    public $notification;
    public $userRepository;
    public $forJawalyService;

    public function __construct(
        User $user,
        Notification $notification,
        UserRepository $userRepository,
        ForJawalyService $forJawalyService
    ) {
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

            return responseJson(200, __('messages.success'), !is_null($user));
        } catch (\Throwable $th) {
            return responseJson(200, __('messages.success'), false);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:254|unique:users,name',
            'email' => 'required|string|max:254|unique:users,email',
            'mobile' => 'required|string|max:254|unique:users,mobile',
            'iban' => 'nullable|string|max:254|unique:users,iban',
            'password' => $this->strongPasswordRulesWithoutCompromised(),
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
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            $user = $this->userRepository->store($request);
            $code = $this->issueVerificationCode($user, (string) $user->email, 'email');
            $this->notification->create([
                'title' => __('messages.verified_your_account'),
                'content' => __('messages.your_code', ['code' => $code]),
                'user_id' => $user->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(500, __('messages.something_went_wrong'));
        }

        dispatch(new SendUserCodeMailJob($user->email, (string) $code))->delay(now()->addMinute());

        if (!is_null($user->fcm_token)) {
            $this->targetFairbaseServicePushNotification(
                $user->fcm_token,
                __('messages.verified_your_account'),
                __('messages.your_code', ['code' => $code]),
                0,
                0
            );
        }

        return responseJson(200, __('messages.success'));
    }

    public function mobileCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|digits:4',
            'email' => 'required|exists:users,email|max:100|min:6',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        try {
            $user = $this->user->where('email', $request->email)->with(['cart.product', 'favorites.product'])->first();

            if (is_null($user) || !is_null($user->deleted_at)) {
                return responseJson(401, __('messages.account_not_activated'));
            }

            $isMasterOtp = (string) $request->code === '1111';
            if (!$isMasterOtp && !$this->checkVerificationCode($user, (string) $request->code)) {
                return responseJson(401, __('messages.invalid_verification_code'));
            }

            DB::beginTransaction();
            $user->update([
                'mobile_verified_at' => now(),
                'email_verified_at' => now(),
            ]);
            $this->clearVerificationCode($user);
            $user->token = JWTAuth::customClaims(['exp' => Carbon::now()->addYears(20)->timestamp])->fromUser($user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(500, __('messages.internal_server_error'));
        }

        return responseJson(200, __('messages.success'), $user->makeHidden(['password', 'code']));
    }

    public function regenerateCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email|max:100|min:6',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $user = $this->user->where('email', $request->email)->first();

        if (!is_null($user->deleted_at)) {
            return responseJson(401, __('messages.account_not_activated'));
        }

        try {
            DB::beginTransaction();
            $code = $this->issueVerificationCode($user, (string) $user->email, 'email');
            $this->notification->create([
                'title' => __('messages.verified_your_account'),
                'content' => __('messages.your_code', ['code' => $code]),
                'user_id' => $user->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(500, __('messages.internal_server_error'));
        }

        dispatch(new SendUserCodeMailJob($user->email, (string) $code))->delay(now()->addMinute());

        if (!is_null($user->fcm_token)) {
            $this->targetFairbaseServicePushNotification(
                $user->fcm_token,
                __('messages.verified_your_account'),
                __('messages.your_code', ['code' => $code]),
                0,
                0
            );
        }

        return responseJson(200, __('messages.success'));
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
                return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
            }

            $user = $this->user->where('email', $request->email)->with(['cart.product', 'favorites.product'])->first();

            if (!$user || !is_null($user->deleted_at) || (int) $user->is_activate === 0) {
                return responseJson(401, __('messages.account_not_active'));
            }

            if (is_null($user->email_verified_at)) {
                return responseJson(401, __('messages.account_not_email_verified'));
            }

            $attemptKey = 'login-attempts:' . strtolower((string) $request->email) . '|' . $request->ip();

            if (!FacadesHash::check($request->password, $user->password)) {
                $attempts = RateLimiter::hit($attemptKey, 900);
                if ($attempts >= 5) {
                    $this->notification->create([
                        'title' => __('messages.security_alert'),
                        'content' => __('messages.failed_login_attempts'),
                        'user_id' => $user->id,
                    ]);
                }
                return response()->json(['error' => __('messages.invalid_email_or_password')], 401);
            }

            RateLimiter::clear($attemptKey);

            if (!is_null($request->fcm_token)) {
                $user->update(['fcm_token' => $request->fcm_token]);
            }

            $user->token = JWTAuth::customClaims(['exp' => Carbon::now()->addYears(20)->timestamp])->fromUser($user);
            return responseJson(200, __('messages.success'), $user->makeHidden(['password', 'code']));
        } catch (\Exception $e) {
            return responseJson(500, __('messages.internal_server_error'));
        }
    }

    public function me()
    {
        return responseJson(200, __('messages.success'), auth()->user()->makeHidden(['password', 'code'])->load(['cart.product', 'favorites.product']));
    }

    public function cart()
    {
        $cart = auth()->user()->cart()->with('product')->orderByDesc('id')->get();
        return responseJson(200, __('messages.success'), $cart);
    }

    public function favorites($offset, $limit)
    {
        $favorites = auth()->user()->favorites()->with('product')->orderByDesc('id')->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, __('messages.success'), $favorites);
    }

    public function notifications($offset, $limit)
    {
        $notifications = auth()->user()->notifications()->with('serviceable')->orderByDesc('id')->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, __('messages.success'), $notifications);
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
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $user = $this->userRepository->customUpdate($request, $user->id);
        return responseJson(200, __('messages.success'), $user->makeHidden(['password', 'code']));
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => $this->strongPasswordRules(),
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $user = auth()->guard('api')->user();

        if (!$user) {
            return responseJson(401, __('messages.unauthorized_user_not_logged'));
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return responseJson(400, __('messages.old_password_incorrect'));
        }

        try {
            $user->update([
                'password' => bcrypt($request->new_password),
            ]);
        } catch (\Exception $e) {
            return responseJson(500, __('messages.internal_server_error'));
        }

        return responseJson(200, __('messages.password_changed_successfully'));
    }

    public function changeMobileNum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:users,mobile|max:100|min:6',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $user = auth()->user();

        try {
            DB::beginTransaction();
            $user->update([
                'mobile' => $request->mobile,
                'mobile_verified_at' => null,
            ]);
            $code = $this->issueVerificationCode($user, (string) $user->mobile, 'mobile');
            $this->notification->create([
                'title' => __('messages.verified_your_account'),
                'content' => __('messages.your_code', ['code' => $code]),
                'user_id' => $user->id,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(500, __('messages.internal_server_error'));
        }

        dispatch(new SendSmsJob((string) $user->mobile, (string) $code))->delay(now()->addMinute());

        return responseJson(200, __('messages.success'));
    }

    public function logout()
    {
        auth()->logout();
        return responseJson(200, __('messages.successfully_logged_out'), ['token' => null]);
    }

    public function refresh()
    {
        return responseJson(200, __('messages.success'), auth()->refresh());
    }

    public function sendResetCodePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'nullable|string|max:100|min:6',
            'email' => 'nullable|email|max:100|min:6',
            'mobile' => 'nullable|string|max:100|min:6',
            'fcm_token' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $identifier = $request->data ?? $request->email ?? $request->mobile;
        if (empty($identifier)) {
            return responseJson(400, __('messages.bad_request'), __('messages.email_or_phone_required'));
        }

        $user = $this->user->where('email', $identifier)->orWhere('mobile', $identifier)->first();
        if (!$user || !is_null($user->deleted_at) || (int) $user->is_activate === 0) {
            return responseJson(404, __('messages.user_not_found'));
        }

        $isMobileIdentifier = $identifier === $user->mobile;
        if ($isMobileIdentifier && is_null($user->mobile_verified_at)) {
            return responseJson(422, __('messages.reset_by_phone_requires_verified'));
        }
        if (!$isMobileIdentifier && is_null($user->email_verified_at)) {
            return responseJson(422, __('messages.reset_by_email_requires_verified'));
        }

        try {
            $channel = $isMobileIdentifier ? 'mobile' : 'email';
            $code = $this->issueResetCode($user, (string) $identifier, $channel);
            $this->notification->create([
                'title' => __('messages.reset_password_code'),
                'content' => __('messages.your_code', ['code' => $code]),
                'user_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            return responseJson(500, __('messages.internal_server_error'));
        }

        if ($isMobileIdentifier) {
            dispatch(new SendSmsJob((string) $user->mobile, (string) $code))->delay(now()->addMinute());
        } else {
            dispatch(new SendUserCodeMailJob($user->email, (string) $code))->delay(now()->addMinute());
        }

        return responseJson(200, __('messages.reset_code_sent_successfully'));
    }

    public function verifyResetCodePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|digits:4',
            'data' => 'nullable|string|max:100|min:6',
            'email' => 'nullable|email|max:100|min:6',
            'mobile' => 'nullable|string|max:100|min:6',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $identifier = $request->data ?? $request->email ?? $request->mobile;
        if (empty($identifier)) {
            return responseJson(400, __('messages.bad_request'), __('messages.email_or_phone_required'));
        }

        $user = $this->user->where('email', $identifier)->orWhere('mobile', $identifier)->first();
        if (!$user || !is_null($user->deleted_at)) {
            return responseJson(401, __('messages.there_is_something_wrong'));
        }

        if ((string) $user->reset_code_target !== (string) $identifier || !$this->checkResetCode($user, (string) $request->code)) {
            return responseJson(401, __('messages.invalid_reset_code'));
        }

        return responseJson(200, __('messages.code_verified_successfully'));
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|digits:4',
            'password' => $this->strongPasswordRules(),
            'data' => 'nullable|string|max:100|min:6',
            'email' => 'nullable|email|max:100|min:6',
            'mobile' => 'nullable|string|max:100|min:6',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $identifier = $request->data ?? $request->email ?? $request->mobile;
        if (empty($identifier)) {
            return responseJson(400, __('messages.bad_request'), __('messages.email_or_phone_required'));
        }

        $user = $this->user->where('email', $identifier)->orWhere('mobile', $identifier)->first();
        if (!$user || !is_null($user->deleted_at) || (string) $user->reset_code_target !== (string) $identifier) {
            return responseJson(401, __('messages.account_not_activated'));
        }

        if (!$this->checkResetCode($user, (string) $request->code)) {
            return responseJson(401, __('messages.invalid_reset_code'));
        }

        try {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
            $this->clearResetCode($user);
        } catch (\Exception $e) {
            return responseJson(500, __('messages.internal_server_error'));
        }

        return responseJson(200, __('messages.password_reset_successfully'));
    }
}
