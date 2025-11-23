<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\StoreSellerRequest;
use App\Models\Category;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorCategory;
use App\Models\VendorUser;
use App\Notifications\SellerRequestToAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Modules\Inventory\Entities\Location;
use Modules\Shop\Http\Models\Shop;
use App\Traits\HasCrmForm;

class AuthController extends Controller
{
    use HasCrmForm;

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
        $categories = Category::activeCategories();
        return view('site.auth.factory-register', compact('categories'));
    }

    public function buyerRegister(Request $request)
    {
        if (preference('customer_signup') != '1') {
            abort(404);
        }

        $validatedData = $request->validate([
            'name' => 'required|min:3|max:191',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed|max:20',
            'phone' => 'required|min:7|max:15|unique:users,phone',
            'commercial_registration_number' => 'required',
        ]);

        $data = $validatedData;

        $status = preference('user_default_signup_status') ?? 'Pending';

        $data['password'] = Hash::make($data['password']);
        $data['status'] = $status;
        $data['activation_code'] = Str::random(10);
        $data['activation_otp'] = random_int(1111, 9999);

        $data['buyer_commercial_registration_number'] = $data['commercial_registration_number'];

        $user = User::create($data);
        
        $role = Role::where('slug', 'customer')->first();
        $roles = ['user_id' => $user->id, 'role_id' => $role->id];
        (new RoleUser())->store($roles);

        // $response['status'] = 'success';
        // $response['message'] = __('Registration successful. Please login to your account.');

        // $this->setSessionValue($response);

        if ($status == 'Pending') {
            $user->sendOtpToEmail();
            return redirect()->route('site.otp-verify', ['email' => $request->email]);
        }

        $this->sendToForm('buyer_register', $validatedData);

        $response['status'] = 'success';
        $response['message'] = __('Registration successful. Please login to your account.');

        $this->setSessionValue($response);


        return redirect()->route('site.login')->withSuccess(__('Registration successful. Please login to your account.'));

    }

    public function factoryRegister(StoreSellerRequest $request)
    {
        if (preference('vendor_signup') != '1') {
            abort(404);
        }

        DB::transaction(function () use ($request) {

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
                $user_id = (new User())->store($request->only('name', 'email', 'password', 'activation_code', 'activation_otp', 'user_status'));
            } else {
                $user_id = $user->id;
            }


             // Store vendor information
             $data['vendorData'] = $request->only('name', 'email', 'phone', 'formal_name', 'website', 'status');
             $vendorId = (new Vendor())->store($data);
 
             // Store shop information
             $request['vendor_id'] = $vendorId;
             $alias = generateAliasForShop($request->name);
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

            $shop = Shop::where('vendor_id', $vendorId)->first();

            foreach ($request->categories as $category) {
                VendorCategory::create([
                    'vendor_id' => $vendorId,
                    'category_id' => $category,
                    'shop_id' => $shop->id,
                ]);
            }

            $formData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->phone,
                'commercial_registration_number' => $request->commercial_registration_number,
                'factory_name' => $request->shop_name,
                'country' => 'Saudi Arabia',
                'state' => $request->state,
                'city' => $request->city,
                'post_code' => $request->post_code,
                'status' => $request->status,
            ];
            

            $this->sendToForm('factory_register', $formData);

            User::find($user_id)->sendOtpToEmail();


        });

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
                session()->put('vendorId', optional($user->vendor())->vendor_id);
                return redirect()->route('vendor-dashboard');
            }

            if ($role == 'customer' && ! $user->is_approved_as_buyer) {
                Auth::logout();
                return redirect()->route('site.login')->withErrors(['email' => __('Your account is not approved yet. wait for approval.')]);
            }
            
            return redirect()->intended(route('site.dashboard'));
        }

        return back()->withInput()->withErrors(['email' => __('Invalid email or password')]);
    }

    public function resendVerificationCode($email)
    {
        $user = User::whereEmail($email)->firstOrFail();

        $user->sendOtpToEmail();

        return redirect()->back()->withSuccess(__('Verification code has been sent to your email.'));
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


    public function otpVerification(Request $request)
    {
        if (empty($request->token)) {
            return redirect()->back()->withErrors(['otp' => __('The OTP field is required.')]);
        }

        $user = User::where('activation_otp', $request->token)->whereEmail($request->email)->first();
        if (empty($user)) {
            $response['message'] = __('Your OTP is invalid.');

            return redirect()->back()->withErrors(['otp' => __('Your OTP is invalid.')]);
        }

        $user->update(['activation_otp' => null, 'activation_code' => null, 'status' => 'Active', 'email_verified_at' => now()]);

        User::admins()->first()->notify(new SellerRequestToAdminNotification($user));

        // Session::forget('martvill-seller');

        $response['status'] = 'success';
        $response['message'] = __('Your account is verified.');
        $this->setSessionValue($response);

        return redirect()->route('login');
    }
}
