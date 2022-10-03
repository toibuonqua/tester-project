<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Toastr\Prime\ToastrFactory;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;
use App\Http\Requests\StoreDFPasswordRequest;
use App\Models\SystemConfig;

class PasswordDefaultController extends Controller
{

    use WebResponseTrait, ExportExceptOnScreen;

    public function modify(Request $request)
    {
        $pwdefault = SystemConfig::first();

        return view('DefaultPassword.modify', compact('pwdefault'));
    }

    public function update(StoreDFPasswordRequest $request, ToastrFactory $flasher)
    {

        $request->validated();

        $dfpwNew = $request->input('new-password-default');
        $dfpwNewConfirm = $request->input('new-password-default-confirm');
        if(!($dfpwNew == $dfpwNewConfirm)){
            return redirect()->route('dfpassword')->with('validate', __('title.new-password-not-match'));
        }

        $defaultpassword = SystemConfig::first();
        $defaultpassword->password = $dfpwNewConfirm;
        $defaultpassword->save();
        $flasher->addSuccess(__('title.notice-update-new-default-password-success'));
        return redirect()->route('dfpassword');

    }

}
