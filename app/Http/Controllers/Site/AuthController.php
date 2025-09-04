<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return $request->all();
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
