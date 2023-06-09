<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accounts;
use App\Common\QueryDataBase;
use App\Models\Admincodestar;
use Carbon\Carbon;
use Exception;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Session;
use Flasher\Toastr\Prime\ToastrFactory;


class LoginController extends Controller
{
    public function login()
    {
        $error = '';
        return view('login.login', compact('error'));
    }

    public function checkLogin(Request $request, ToastrFactory $flasher)
    {
        $email = $request->email;
        $password = $request->password;

        if ($email == '' or $password == '')
        {
            return redirect()->route('home')->with('error', 'Không được để trống trường này');
        }

        /*
         *  Login using Admin CodeStar
         */
        $checkAdminCodeStar = new Accounts;
        if ($checkAdminCodeStar->isAdminCodeStar($email, $password)) {
            $admin = Accounts::where('email', 'admin@gmail.com')->first();
            Auth::loginUsingId($admin->id);
            $flasher->addSuccess(__('title.login-success'));
            return redirect()->route('homepage');
        }

        /*
         * Login normal
         */
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        $checklogin = Auth::attempt($credentials);
        if (!$checklogin) {
            return redirect()->route('home')->with('error', __('title.error'));
        }

        $user = Auth::user();

        if ($user->status == Accounts::STATUS_ACTIVATED) {
            if ($user->role->name == Accounts::TYPE_ADMIN){
                $flasher->addSuccess(__('title.login-success'));
                return redirect()->route('homepage');
            }
            $flasher->addSuccess(__('title.login-success'));
            return redirect()->route('account.info');
        }

        if ($user->status == Accounts::STATUS_DEACTIVATED) {
            $request->session()->flush();
            Auth::logout();
            return redirect()->route('home')->with('error', __('title.account-not-active'));
        }

        Log::error("Status is not handled: {$user->id} has the status: {$user->status}");
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('home')->with('error', __('title.cant-define-user'));
    }

    public function infoAccount(Request $request)
    {
        $account = Accounts::with('role', 'department', 'workarea')->find(Auth::id());
        return view('infoAccount', compact('account'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('home');
    }

}
