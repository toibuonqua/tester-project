<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Workarea;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;
use Illuminate\Support\Facades\Auth;

class UsersManagementController extends Controller
{

    use WebResponseTrait, ExportExceptOnScreen;
    public function index(Request $request)
    {

        $accounts = Accounts::with('role', 'department', 'workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        foreach ($accounts as $account) {
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };

        return view('userManagement.usersmanagement', compact('accounts'));
    }

    public function add(Request $request)
    {
        $departments = Department::all();
        $roles = Role::all();

        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }

        return view('userManagement.adduser', compact('departments', 'roles'));
    }

    public function modify($id)
    {
        $departments = Department::all();
        $roles = Role::all();

        $account = Accounts::with(['role', 'department'])->find($id);
        $workarea = Workarea::find($account->workarea_id);

        return view('userManagement.moduser', compact('account', 'workarea', 'departments', 'roles'));
    }

    public function detail($id)
    {
        $account = Accounts::with('role', 'department', 'workarea')->find($id);

        return view('userManagement.detailuser', compact('account'));
    }

    public function update($id, Request $request)
    {
        $account = Accounts::query()->findOrFail($id);
        $data = $request->only('username', 'email', 'phone_number', 'status', 'code_user', 'department_id', 'role_id');
        $account->update($data);

        return redirect()->route('homepage');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:accounts',
            'username' => 'required',
            'phone_number' => 'required',
            'code_user' => 'required',
            'department_id' => 'required',
            'role_id' => 'required',
        ]);


        // Không có input cho khu vực làm việc
        $account = new Accounts;
        $account->username = $request->input('username');
        $account->email = $request->input('email');
        $account->phone_number = $request->input('phone_number');
        $account->code_user = $request->input('code_user');
        $account->department_id = $request->input('department_id');
        $account->role_id = $request->input('role_id');
        $account->manager_id = Auth::user()->id;
        $account->hashPassword();
        $account->save();
        return redirect()->route('homepage');
    }

    public function search(Request $request)
    {
        $search_text = $request->input("query");
        $accounts = Accounts::where('username', 'like', '%' . $search_text . '%')->with('role', 'department', 'workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        foreach ($accounts as $account) {
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };


        return view('userManagement.usersmanagement', compact('accounts'));
    }

    public function active($id)
    {
        $account = Accounts::find($id);

        if ($account->status === Accounts::STATUS_ACTIVATED) {
            $account->status = Accounts::STATUS_DEACTIVATED;
        } else {
            $account->status = Accounts::STATUS_ACTIVATED;
        }
        $account->save();

        return redirect()->route('homepage');
    }

    public function resetpw($id)
    {
        $account = Accounts::find($id);
        $account->password = Hash::make(Accounts::DEFAULT_PASSWORD);
        $account->save();
        return redirect()->route('homepage');
    }

    public function changePassword(Request $request)
    {
        $email = Auth::user()->email;

        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }

        return view('ChangePassword.changepassword', compact('email'));
    }

    public function passwordUpdate(Request $request)
    {

        $request->validate([
            'old-password' => 'required',
            'new-password' => 'required',
            'confirm-new-password' => 'required',

        ]);

        if(Auth::attempt(['email' => Auth::user()->email,'password' => $request->input('old-password')]))
        {
            $newPw = $request->input('new-password');
            $confirmNewPw = $request->input('confirm-new-password');
            if($newPw == $confirmNewPw)
            {
                $account = Accounts::find(Auth::id());
                $account->password = Hash::make($newPw);
                $account->save();
                return redirect()->route('back.login')->with('notice-login', 'Mật khẩu mới đã đổi thành công, hãy dùng mật khẩu mới để đăng nhập');
            }
            else
            {
                return redirect()->route('account.changepw')->with('error-confirm', __('title.new-password-not-match'));
            }
        }
        else
        {
            return redirect()->route('account.changepw')->with('error-old-pw', __('title.error-old-password'));
        }

    }

    public function noticeLogin()
    {
        return view('ChangePassword.noticeLogout');
    }

}
