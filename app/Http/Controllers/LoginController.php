<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts;
use App\Common\QueryDataBase;

class LoginController extends Controller
{
    use QueryDataBase;
    public function login() {
        return view('login.login');
    }

    public function checkLogin(Request $request)
    {
        $message = $this->checkAccount($request);
        dd($message);
        if ($message === 'pass')
        {
            return redirect()->route('homepage');
        }
        else
        {
            return redirect()->route('home');
        }
    }
}
