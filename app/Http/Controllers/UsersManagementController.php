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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccountsExport;
use Carbon\Carbon;
use Flasher\Toastr\Prime\ToastrFactory;
use App\Common\MakeArray;


class UsersManagementController extends Controller
{

    use WebResponseTrait, ExportExceptOnScreen, MakeArray;

    // view Index
    public function index(Request $request)
    {

        $accounts = Accounts::with('role', 'department', 'workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        foreach ($accounts as $account) {
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };

        // get data to export excel
        $dataexport = Accounts::with('role', 'department', 'workarea')->get();
        foreach ($dataexport as $value) {
            $value->role_name = $value->role->name;
            $value->department_name = $value->department->name;
            $value->workarea_code = $value->workarea->work_areas_code;
        };
        $request->session()->put('accounts', $dataexport);

        return view('userManagement.usersmanagement', compact('accounts'));
    }

    // View add
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

    // View modify
    public function modify($id)
    {
        $departments = Department::all();
        $roles = Role::all();

        $account = Accounts::with(['role', 'department'])->find($id);
        $workarea = Workarea::find($account->workarea_id);

        return view('userManagement.moduser', compact('account', 'workarea', 'departments', 'roles'));
    }

    // View detail
    public function detail($id)
    {
        $account = Accounts::with('role', 'department', 'workarea')->find($id);

        return view('userManagement.detailuser', compact('account'));
    }

    // update user info
    public function update($id, Request $request, ToastrFactory $flasher)
    {
        $account = Accounts::query()->findOrFail($id);
        $data = $request->only('username', 'email', 'phone_number', 'status', 'code_user', 'department_id', 'role_id');
        $account->update($data);
        $flasher->addSuccess(__('title.notice-modify-user-success'));

        return redirect()->route('homepage');
    }

    // Add new user
    public function store(Request $request, ToastrFactory $flasher)
    {
        $request->validate([
            'email' => 'required|email|unique:accounts',
            'username' => 'required',
            'phone_number' => 'required',
            'code_user' => 'required|integer',
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
        $flasher->addSuccess(__('title.notice-add-user-success'));
        return redirect()->route('homepage');
    }

    // search bar
    public function search(Request $request)
    {
        $search_text = $request->input("query");
        $accounts = Accounts::where('username', 'like', '%' . $search_text . '%')->with('role', 'department', 'workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        foreach ($accounts as $account) {
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };

        // get data to export excel
        $dataexport = Accounts::where('username', 'like', '%' . $search_text . '%')->with('role', 'department', 'workarea')->get();

        foreach ($dataexport as $value) {
            $value->role_name = $value->role->name;
            $value->department_name = $value->department->name;
            $value->workarea_code = $value->workarea->work_areas_code;
        };
        $request->session()->put('accounts', $dataexport);

        return view('userManagement.usersmanagement', compact('accounts'));
    }

    // Export excel file
    public function export(Request $request)
    {
        $accounts = $request->session()->get('accounts');
        $result = $this->backArray($accounts, [
            'username',
            'email',
            'department_name',
            'role_name',
            'workarea_code',
            'created_at',
            'updated_at',
        ]);
        $time = Carbon::now()->format('YmdHi');
        return Excel::download(new AccountsExport($result), 'danhsachnguoidung_'.$time.'.xlsx');
    }


    // Change status user
    public function active($id, ToastrFactory $flasher)
    {
        $account = Accounts::find($id);
        $account->activate()->save();
        if ($account->status == Accounts::STATUS_ACTIVATED)
        {
            $flasher->addSuccess(__('title.active-user'));
        }
        else
        {
            $flasher->addSuccess(__('title.deactive-user'));
        }
        return redirect()->route('homepage');
    }

    // reset password user
    public function resetpw($id, ToastrFactory $flasher)
    {
        $account = Accounts::find($id);
        $account->resetPassword()->save();
        $flasher->addSuccess(__('title.notice-reset-password-succcess'));
        return redirect()->route('homepage');
    }

    // view change password
    public function changePassword(Request $request)
    {
        $email = Auth::user()->email;

        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }

        return view('ChangePassword.changepassword', compact('email'));
    }

    // Change password
    public function passwordUpdate(Request $request)
    {

        // Validate field in view change password
        $request->validate([
            'old-password' => 'required',
            'new-password' => 'required',
            'confirm-new-password' => 'required',

        ]);

        // Check old password.
        if(!Auth::attempt(['email' => Auth::user()->email,'password' => $request->input('old-password')]))
        {
            return redirect()->route('account.changepw')->with('error-old-pw', __('title.error-old-password'));
        }

        // Check confirm new password.
        $newPw = $request->input('new-password');
        $confirmNewPw = $request->input('confirm-new-password');
        if(!($newPw == $confirmNewPw))
        {
            return redirect()->route('account.changepw')->with('error-confirm', __('title.new-password-not-match'));
        }

        // Change password and login.
        $account = Accounts::find(Auth::id());
        $account->setPassword($newPw)->save();
        return redirect()->route('back.login')->with('notice-login', 'Mật khẩu mới đã đổi thành công, hãy dùng mật khẩu mới để đăng nhập');
    }

    // Notice about reLogin.
    public function noticeLogin()
    {
        return view('ChangePassword.noticeLogout');
    }

}
