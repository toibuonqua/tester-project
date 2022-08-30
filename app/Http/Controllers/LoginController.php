<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts;
use App\Common\QueryDataBase;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Session;


class LoginController extends Controller
{
    public function login()
    {
        $error = '';
        return view('login.login', compact('error'));
    }

    public function checkLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        Log::error($credentials);
        $checklogin = Auth::attempt($credentials);
        Log::error($checklogin);
        if ($checklogin) {
            $user = Auth::user();
            if ($user->status == 'active') 
            {
                return redirect()->route('homepage');
            } 
            else 
            {
                $request->session()->flush();
                 Auth::logout();
                return redirect()->route('home')->with('error', __('title.account-not-active'));
            }
        } else return redirect()->route('home')->with('error', __('title.error'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('home');
    }
}
