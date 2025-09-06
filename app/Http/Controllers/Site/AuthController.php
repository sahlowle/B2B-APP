<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        return redirect()->route('login');
    }

    public function factoryRegister(Request $request)
    {
        return $request->all();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $user = auth()->user();
            $role = $user->role()->type;

            if (! $user->isActive()) {
                Auth::logout();
                return back()->withInput()->withErrors(['error' => __('Inactive User')]);
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
}
