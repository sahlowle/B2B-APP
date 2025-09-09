<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\StoreSellerRequest;
use App\Mail\SendOtp;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Inventory\Entities\Location;
use Modules\Shop\Http\Models\Shop;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('site.auth.login');
    }

    public function showRegisterForm()
    {
        return view('site.auth.register');
    }

    public function buyerRegisterForm()
    {
        return view('site.auth.buyer-register');
    }

    public function factoryRegisterForm()
    {
        return view('site.auth.factory-register');
    }

    public function buyerRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|max:20',
            'phone' => 'required|min:7|max:15|unique:users,phone',
            'commercial_registration_number' => 'required',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['activation_code'] = Str::random(10);
        $data['activation_otp'] = random_int(1111, 9999);


        $user = User::create($data);
        
        $role = Role::where('slug', 'customer')->first();
        $roles = ['user_id' => $user->id, 'role_id' => $role->id];
        (new RoleUser())->store($roles);

        $response['status'] = 'success';
        $response['message'] = __('Registration successful. Please login to your account.');

        $this->setSessionValue($response);

        $user->sendOtpToEmail();

        return redirect()->route('login');
    }

    public function factoryRegister(StoreSellerRequest $request)
    {
        if (preference('vendor_signup') != '1') {
            abort(404);
        }

        $user = DB::transaction(function () use ($request) {
            $user = User::whereEmail($request->email)->first();
            $has_vendor = User::whereHas('vendorUser')->whereEmail($request->email)->first();
            $vendor = Vendor::withTrashed()->whereEmail($request->email)->first();

            if ($vendor) {
                $response['status'] = 'error';
                $response['message'] = __('The email address has already been taken.');
                $this->setSessionValue($response);

                // return redirect()->back();
                return back()->withInput()->withErrors(['email' => __('The email address has already been taken.')]);
            }

            if ($has_vendor) {
                $response['status'] = 'error';
                $response['message'] = __('You are already registered.');
                $this->setSessionValue($response);

                // return redirect()->route('login');
                return back()->withInput()->withErrors(['email' => __('You are already registered.')]);
            }

            $user_id = null;
            // Store user information
            if (empty($user)) {
                $request['password'] = Hash::make($request->password);
                $user_id = (new User())->store($request->only('name', 'email', 'password', 'activation_code', 'activation_otp', 'status'));
            } else {
                $user_id = $user->id;
            }


             // Store vendor information
             $data['vendorData'] = $request->only('name', 'email', 'phone', 'formal_name', 'website', 'status');
             $vendorId = (new Vendor())->store($data);
 
             // Store shop information
             $request['vendor_id'] = $vendorId;
             $alias = cleanedUrl($request->name);
             $request->merge(['alias' => $alias]);
             
             (new Shop())->store($request->only('commercial_registration_number','name', 'vendor_id', 'email', 'website', 'alias', 'phone', 'address', 'country', 'state', 'city', 'post_code'));
 
             if (! empty($user_id)) {
                $roleId = Role::where('slug', 'vendor-admin')->first()->id;
                $roles = ['user_id' => $user_id, 'role_id' =>  $roleId];

                if (! empty($roles)) {
                    (new RoleUser())->update($roles);
                }

                $request['user_id'] = $user_id;
                (new VendorUser())->store($request->only('vendor_id', 'user_id', 'status'));
                
                // (new BeASellerMailService())->send($request);
            }

            Location::store([
                'name' => $request->name,
                'slug' => $request->alias,
                'parent_id' => null,
                'vendor_id' => $vendorId,
                'status' => 'Active',
                'is_default' => 1,
            ]);

            return $user;
        });

        
        $response['status'] = 'success';
        $response['message'] = __('Registration successful. Please login to your account.');
        
        $this->setSessionValue($response);
        
        // return redirect()->route('login');

        $user->sendOtpToEmail();

        // Session::put('martvill-seller', $user);

        return redirect()->route('site.otp-verify', ['email' => $request->email]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // return $request->all();

        if (Auth::attempt($request->only('email', 'password'))) {

            $user = auth()->user();
            $role = $user->role()->type;

            // return $user;

            if (! $user->isActive()) {
                $user->sendOtpToEmail();
                Auth::logout();
                $response['status'] = 'error';
                $response['message'] = __('Verify your account.');
                $this->setSessionValue($response);
                return redirect()->route('site.otp-verify', ['email' => $user->email]);
                // return back()->withInput()->withErrors(['email' => __('Inactive User')]);
            }

            if ($role == 'admin') {
                return redirect()->route('dashboard');
            } else if ($role == 'vendor') {
                return redirect()->route('vendor-dashboard');
            }
            
            return redirect()->intended(route('site.index'));
        }

        return back()->withInput()->withErrors(['email' => __('Invalid email or password')]);
    }


    public function otpForm(Request $request)
    {
        abort_if($request->isNotFilled('email'), 404, __('Invalid Request'));

        $user = User::whereEmail($request->email)->firstOrFail();

        
        if (! empty($user) && empty($user->email_verified_at)) {
            return view('site.vendor.otp', ['user' => $user]);
        }

        $response['status'] = 'success';
        $response['message'] = __('Your account is already verified.');
        $this->setSessionValue($response);

        return redirect()->route('site.login')->withErrors(['email' => __('Your account is already verified.')]);
    }
}
