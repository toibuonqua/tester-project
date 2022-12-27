<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersManagementController extends Controller
{

    const CHECK_OLD_PASSWORD_COMPLETE = 'CHECK_OLD_PASSWORD_COMPLETE';
    public function checkPasswordUser(Request $request)
    {
        $old_password = $request->input('password');

        if (Hash::check($old_password, Auth::user()->password)) {

            return response()->json([
                'status' => self::CHECK_OLD_PASSWORD_COMPLETE,
                'data' => [
                    'isOldPassword' => true,
                ]
            ]);
        }

        return response()->json([
            'status' => self::CHECK_OLD_PASSWORD_COMPLETE,
            'data' => [
                'isOldPassword' => false,
            ]
        ]);
    }
}
