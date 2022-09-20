<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefaultPassword;
use Flasher\Toastr\Prime\ToastrFactory;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;

class PasswordDefaultController extends Controller
{

    use WebResponseTrait, ExportExceptOnScreen;

    public function modify(Request $request)
    {

        $pwdefault = DefaultPassword::first();
        $error = $request->session()->get('errors');

        if ($error) {
            if ($error) {
                $this->updateFailMessage($request, $this->backString($request, $error));
            }
        }

        return view('DefaultPassword.modify', compact('pwdefault'));

    }

    public function update(Request $request, ToastrFactory $flasher)
    {

        $request->validate([
            'new-password-default' => 'required|min:8',
            'new-password-default-confirm' => 'required|min:8',
        ]);

        $dfpwNew = $request->input('new-password-default');
        $dfpwNewConfirm = $request->input('new-password-default-confirm');
        if(!($dfpwNew == $dfpwNewConfirm)){
            return redirect()->route('dfpassword')->with('validate', __('title.new-password-not-match'));
        }

        $defaultpassword = DefaultPassword::first();
        $defaultpassword->password = $dfpwNewConfirm;
        $defaultpassword->save();
        $flasher->addSuccess(__('title.notice-update-new-default-password-success'));
        return redirect()->route('dfpassword');

    }
    
}
