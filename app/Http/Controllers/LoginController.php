<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sabbir Al-Razi <[sabbir.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 20-05-2021
 *
 * @modified 30-05-2022
 */

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AuthUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\{
    User,
    PasswordReset,
};
use App\Notifications\ResetPasswordNotification;
use App\Notifications\UserPasswordSetNotification;
use Auth;
use Session;
use DB;
use Cookie;
use App\Services\ActivityLogService;
use App\Services\AuthService;
use InvalidArgumentException;

class LoginController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ckname = explode('_', Auth::getRecallerName())[2];

        if (! request()->has('template')) {
            $this->middleware('guest:user')->except('logout', 'impersonate', 'cancelImpersonate');
        }
    }

    // use AuthenticatesUsers;
    /**
     * @return login page view
     */
    public function showLoginForm(AuthService $authService)
    {
        // Now log in the user if exists
        if ($authService->needsAutoAuthentication()) {
            $authService->autoAuthenticate();

            return redirect()->intended(route('site.index'));
        }


        if (strpos(url()->current(), 'admin') !== false) {
            return redirect('/auth/login');
        }

        $value = Cookie::get($this->ckname);
        if (! is_null($value) && ! request()->has('template')) {
            $rememberedUser = explode('.', explode($this->ckname, decrypt($value))[1]);
            if ($rememberedUser[1] == 'user' && Auth::guard('user')->loginUsingId($rememberedUser[0])) {
                $ckkey = encrypt($this->ckname . Auth::user()->id . '.user');
                Cookie::queue($this->ckname, $ckkey, 2592000);

                return redirect()->intended(route('dashboard'));
            }
        }

        $data['settings'] = $this->getAuthSettings();

        if (request()->has('template') && array_key_exists(request('template'), $data['settings']) && auth()->user() && auth()->user()->role()->type == 'admin') {
            $data['template'] = request('template');
        }

        try {
            return view('admin.auth.partial.login', $data);
        } catch (InvalidArgumentException $th) {
            return view('admin.auth.login');
        }
    }

    /**
     * Login authenticate operation.
     *
     * @return redirect dashboard page
     */
    public function authenticate(AuthUserRequest $request)
    {
        $data = $request->only('email', 'password');
        $data['status'] = 'Active';
        $userData = User::where('email', $data['email'])->first();

        if (\Hash::check($data['password'], $userData->password)) {
            if ($userData->status != 'Active') {
                (new ActivityLogService())->userLogin('failed', 'Inactive');

                return back()->withInput()->withErrors(['error' => __('Inactive User')]);
            }

            if (Auth::guard('user')->attempt($data)) {
                session()->put('vendorId', optional(auth()->user()->vendor())->vendor_id);
                if (! is_null($request->remember)) {
                    $ckkey = encrypt($this->ckname . Auth::user()->id . '.user');
                    Cookie::queue($this->ckname, $ckkey, 2592000);
                }
                if (auth()->user()->role()->type == 'admin') {
                    if ($this->ncpc()) {
                        Session::flush();

                        return view('errors.installer-error', ['message' => __('This product is facing license validation issue.') . '<br>' . __('Please verify your purchase code from :x.', ['x' => '<a style="color:#fcca19" href="' . route('purchase-code-check', ['bypass' => 'purchase_code']) . '">' . __('here') . '</a>'])]);
                    }
                    (new ActivityLogService())->userLogin('success', 'Login successful');

                    return redirect()->intended(route('dashboard'));
                }
                if ($this->ncpc()) {
                    Session::flush();

                    return view('errors.installer-error', ['message' => __('This product is facing license validation issue.<br>Please contact admin to fix the issue.')]);
                }

                if (isActive('Pos') && version_compare(module('Pos')->get('version'), '2.0', '>=')) {
                    expirePosSession(auth()->user()?->id);
                }

                if (auth()->user()->role()->type != 'vendor' || auth()->user()->vendors()->first()->status != 'Active') {
                    (new ActivityLogService())->userLogin('failed', 'Inactive');

                    return redirect()->intended(route('site.index'));
                }

                (new ActivityLogService())->userLogin('success', 'Login successful');

                return redirect()->intended(route('vendor-dashboard'));
            }

            return back()->withInput()->withErrors(['error' => __('Invalid User')]);
        } else {
            (new ActivityLogService())->userLogin('failed', 'Incorrect');

            return back()->withInput()->withErrors(['email' => __('Invalid email or password')]);
        }
    }

    /**
     * logout operation.
     *
     * @return redirect login page view
     */
    public function logout()
    {
        $cookie = Cookie::forget($this->ckname);
        $user = Auth::user();
        Auth::guard('user')->logout();

        if (isset($user)) {
            (new ActivityLogService())->userLogout('success', 'Logout successful', $user);
        }

        if (isActive('Affiliate')) {
            $helper = \Modules\Affiliate\Services\AffiliateHelper::getInstance();
            $helper->destroy();
        }

        if ($user && isActive('Pos') && version_compare(module('Pos')->get('version'), '2.0', '>=')) {
            expirePosSessionNow($user->id);
        }

        Session::flush();

        return redirect()->route('login')->withCookie($cookie);
    }

    /**
     * forget password
     *
     * @return forget password form
     */
    public function reset()
    {
        $this->data = ['page_title' => __('Reset Password'), 'settings' => $this->getAuthSettings()];

        return view('admin.auth.passwords.email', $this->data);
    }

    /**
     * Opt form
     *
     * @return forget password form
     */
    public function resetOtp()
    {
        $settings = $this->getAuthSettings();

        return view('admin.auth.passwords.otp', compact('settings'));
    }

    /**
     * Send reset password link
     *
     * @return null
     */
    public function sendResetLinkEmail(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        $validator = PasswordReset::storeValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $request['token'] = Password::getRepository()->createNewToken();
        $request['otp'] = random_int(1111, 9999);
        $request['created_at'] = date('Y-m-d H:i:s');

        try {
            \DB::beginTransaction();
            (new PasswordReset())->storeOrUpdate($request->only('email', 'token', 'otp', 'created_at'));
            User::firstWhere('email', $request->email)->notify(new ResetPasswordNotification($request));

            $data['status'] = 'success';
            $data['message'] = __('Password reset link sent to your email address.');
            \DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $data['status'] = 'fail';
            $data['message'] = $e->getMessage();
        }
        $this->setSessionValue($data);

        if (User::userVerification('otp')) {
            return redirect()->route('reset.otp')->withInput();
        }

        return redirect()->back();
    }

    /**
     * showResetForm method
     *
     * @param  string  $tokens
     * @return show reset password page view
     */
    public function showResetForm(Request $request, $tokens = null)
    {
        if (! empty($tokens)) {
            $tokens = $request->token;
        }
        $token = (new PasswordReset())->tokenExist($tokens);

        if (empty($token) || empty($request->token)) {
            return redirect()->route('reset.otp')->withErrors(['email' => __('Invalid password token')]);
        }

        $data = ['token' => $tokens];
        $data['user'] = (new User())->getData($tokens);

        if (! $data['user']) {
            return redirect()->back()->withErrors(['email' => __('Invalid password token')]);
        }

        $data['settings'] = $this->getAuthSettings();

        return view('admin.auth.passwords.reset', $data);
    }

    /**
     * @return redirect login page view
     */
    public function setPassword(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $response = $this->checkExistence($request->id, 'users', ['getData' => true]);
            if ($response['status'] === true) {
                $validator = PasswordReset::passwordValidation($request->all());
                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }
                $request['user_name'] =  $response['data']->name;
                $request['email'] =  $response['data']->email;
                $request['raw_password'] = $request->password;
                $request['updated_at'] = date('Y-m-d H:i:s');
                $request['password'] = \Hash::make(trim($request->password));

                if ((new PasswordReset())->updatePassword($request->only('password', 'token', 'updated_at'), $request->id)) {
                    User::firstWhere('email', $request->email)->notify(new UserPasswordSetNotification($request));

                    $data['status'] = 'success';
                    $data['message'] = __('Password updated successfully.');
                } else {
                    $data['message'] = __('Nothing is updated.');
                }
            } else {
                $data['message'] = $response['message'];
            }
        }

        $this->setSessionValue($data);

        return redirect()->route('login');
    }

    /**
     * Impersonate as another user
     *
     * @return redirect
     */
    public function impersonate(Request $request)
    {
        $password = techDecrypt($request->impersonate);

        $user = User::where('password', $password)->first();

        if (! session()->has('impersonator')) {
            session(['impersonator' => auth()->id()]);
        }
        Auth::loginUsingId($user->id);
        session()->put('vendorId', optional(auth()->user()->vendor())->vendor_id);

        return redirect(route('site.index'));
    }

    /**
     * Cancel Impersonate
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function cancelImpersonate()
    {
        Auth::loginUsingId(session('impersonator'));
        session()->forget('impersonator');
        session()->forget('vendorId');

        return redirect(route('dashboard'));
    }

    public function ncpc()
    {
        return false;
        if (! g_e_v()) {
            return true;
        }
        if (! g_c_v()) {
            try {
                $d_ = g_d();
                $e_ = g_e_v();
                $e_ = explode('.', $e_);
                $c_ = md5($d_ . $e_[1]);
                if ($e_[0] == $c_) {
                    p_c_v();

                    return false;
                }

                return true;
            } catch (\Exception $e) {
                return true;
            }
        }

        return false;
    }

    /**
     * Auth Settings
     *
     * @return array
     */
    private function getAuthSettings()
    {
        $authSettingJson = preference('auth_settings', []) ?: defaultAuthSettings();

        return json_decode($authSettingJson, true);
    }

    /**
     * showRegisterForm method
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        if (auth()->user()) {
            return redirect()->back();
        }

        return view('admin.auth.register');
    }
}
