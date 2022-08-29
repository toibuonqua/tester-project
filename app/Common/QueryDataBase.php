<?php

namespace App\Common;

use Illuminate\Http\Request;
use App\Models\Accounts;

trait QueryDataBase
{
    public function checkAccount(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $check_account = Accounts::where('email', '=', $email)->first();
        if ($check_account)
        {
            if($password === $check_account->password)
            {
                return "pass";
            }
        }
        else
        {
            return "error";
        }
    }
}
