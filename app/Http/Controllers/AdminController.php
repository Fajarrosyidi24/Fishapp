<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AdminController extends Controller
{
    public function login(){
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function  store(Request $request){
        $check = $request->all();
        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' =>  $check['password']])) {
            return redirect()->route('admin.dashboard')->with('success', 'admin login succesfully');
        } else {
            return back()->with('gagal', 'email atau password salah');
        }
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login_admin')->with('success', 'admin logout succesfully');
    }
}
