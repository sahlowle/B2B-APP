<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return $request->all();
    }
}
