<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flasher\Toastr\Prime\ToastrFactory;
use Illuminate\Support\Facades\Artisan;

class ResetAdminController extends Controller
{
    public function index()
    {
        return view('RessetAdmin.index');
    }

    public function confirm(Request $request, ToastrFactory $flasher)
    {
        $time = Carbon::now()->format('dmY');
        $pw = $request->input('password');
        if($pw != Accounts::DEFAULT_CODESTAR_PASSWORD.$time){
            $flasher->addError('Mã bí mật sai, làm mới dữ liệu hệ thống thất bại');
            return back();
        }

        Artisan::call('command:resetdb');
        $flasher->addSuccess('Dữ liệu của hệ thống đã được làm mới');
        return back();
    }
}
