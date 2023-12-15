<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    //Admin Login Page Method
    public function login()
    {
        return view('admin.auth.admin_login');
    }
    //Admin Authentication Method
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => "required|email|exists:admins,email",
            'password' => "required|min:8",
            'remember' => 'nullable|string'
        ]);
        $remember = $request->remember == "on" ? true : false;

        if (Auth::guard('admin')->attempt(
            [
                'email' => $request->email,
                'password' => $request->password
            ],
            $remember
        )) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->with('error', 'Invalid credentials');
    }

    //Admin Logout Method
    public function logout(Request $request)
    {
        Auth::guard("admin")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
    //Admin Forgot Password Page
    public function forgot_password()
    {
        return view('admin.auth.admin_forgot_password');
    }
}
