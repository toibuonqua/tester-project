<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Workarea;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccountsExport;
use App\Http\Controllers\ControllerTrait\GetEmployees;
use App\Models\SystemConfig;
use App\Http\Controllers\ControllerTrait\MakeAttribute;
use Carbon\Carbon;
use Flasher\Toastr\Prime\ToastrFactory;




class UsersManagementController extends Controller
{
    use WebResponseTrait, ExportExceptOnScreen, GetEmployees, MakeAttribute;

    // view Index
    public function index(Request $request)
    {

        $accounts_data = Accounts::with('role', 'department', 'workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        $accounts = $this->addAttribute($accounts_data, [
            "role_name" => "role.name",
            "department_name" => "department.name",
            "workarea_code" => "workarea.work_areas_code",
        ]);

        $query = '';
        $request->session()->put('query', $query);

        return view('userManagement.usersmanagement', compact('accounts', 'query'));
    }

    // View add
    public function add(Request $request)
    {
        $departments = Department::all();
        $roles = Role::all();
        $workareas = Workarea::all();

        return view('userManagement.adduser', compact('departments', 'roles', 'workareas'));
    }

    // View modify
    public function modify($id, ToastrFactory $flasher)
    {
        $account = Accounts::with('role', 'department', 'workarea')->find($id);
        if ($account->role->name == Accounts::TYPE_ADMIN and !($this->returnEmployees($account->email))) {
            $flasher->addError(__('title.account-permission-denied'));
            return back();
        }

        $workareas = Workarea::all();
        $departments = Department::all();
        $roles = Role::all();
        return view('userManagement.moduser', compact('account', 'workareas', 'departments', 'roles'));
    }

    // View detail
    public function detail($id)
    {
        $account = Accounts::with('role', 'department', 'workarea')->find($id);

        return view('userManagement.detailuser', compact('account'));
    }

    // update user info
    public function update($id, UpdateUserRequest $request, ToastrFactory $flasher)
    {
        $request->validated();
        $account = Accounts::find($id);
        $data = $request->only('username', 'phone_number', 'status', 'code_user', 'department_id', 'role_id', 'workarea_id');
        $account->update($data);
        $flasher->addSuccess(__('title.notice-modify-user-success'));
        return redirect()->route('homepage');
    }

    // Add new user
    public function store(StoreUserRequest $request, ToastrFactory $flasher)
    {
        $validated = $request->validated();

        $defaultpassword = new SystemConfig;
        $account = new Accounts;
        $account->username = $request->input('username');
        $account->email = $request->input('email');
        $account->phone_number = $request->input('phone_number');
        $account->code_user = $request->input('code_user');
        $account->department_id = $request->input('department_id');
        $account->role_id = $request->input('role_id');
        $account->workarea_id = $request->input('workarea_id');
        $account->manager_id = Auth::id();
        $account->password = $defaultpassword->getdefaultPassword();
        $account->hashPassword();
        $account->save();
        $flasher->addSuccess(__('title.notice-add-user-success'));
        return redirect()->route('homepage');
    }

    // search bar
    public function search(Request $request)
    {
        $query = $request->input("query");
        $accounts_data = Accounts::where('username', 'like', '%' . $query . '%')->with('role', 'department', 'workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        $accounts = $this->addAttribute($accounts_data, [
            "role_name" => "role.name",
            "department_name" => "department.name",
            "workarea_code" => "workarea.work_areas_code",
        ]);

        $request->session()->put('query', $query);

        return view('userManagement.usersmanagement', compact('accounts', 'query'));
    }

    // Export excel file
    public function export(Request $request)
    {
        $query = $request->session()->get('query');
        $accounts_data = Accounts::with('role', 'department', 'workarea')->where('username', 'like', '%'.$query.'%')->orderBy('created_at', 'DESC')->get();
        $accounts = $this->addAttribute($accounts_data, [
            "role_name" => "role.name",
            "department_name" => "department.name",
            "workarea_code" => "workarea.work_areas_code",
        ]);
        $time = Carbon::now()->format('YmdHi');
        return Excel::download(new AccountsExport($accounts), 'danhsachnguoidung_'.$time.'.xlsx');
    }


    // Change status user
    public function active($id, ToastrFactory $flasher)
    {
        $account = Accounts::with('role')->find($id);
        if ($account->role->name == Accounts::TYPE_ADMIN and !($this->returnEmployees($account->email))) {
            $flasher->addError(__('title.account-permission-denied'));
            return back();
        }
        $account->activate()->save();
        if ($account->status == Accounts::STATUS_ACTIVATED)
        {
            $flasher->addSuccess(__('title.active-user'));
        }
        else
        {
            $flasher->addSuccess(__('title.deactive-user'));
        }
        return back();
    }

    // reset password user
    public function resetpw($id, ToastrFactory $flasher)
    {
        $account = Accounts::with('role')->find($id);
        if ($account->role->name == Accounts::TYPE_ADMIN and !($this->returnEmployees($account->email))) {
            $flasher->addError(__('title.account-permission-denied'));
            return back();
        }
        $account->resetPassword()->save();
        $flasher->addSuccess(__('title.notice-reset-password-succcess'));
        return back();
    }

    // view change password
    public function changePassword(Request $request)
    {
        $email = Auth::user()->email;

        return view('ChangePassword.changepassword', compact('email'));
    }

    // Change password
    public function passwordUpdate(PasswordRequest $request)
    {

        // Validate field in view change password
        $request->validated();

        // Check old password.
        if(!Auth::attempt(['email' => Auth::user()->email,'password' => $request->input('old-password')]))
        {
            return redirect()->route('account.changepw')->with('error-old-pw', __('title.error-old-password'));
        }

        // check new password
        if($request->input('new-password') == $request->input('old-password'))
        {
            return redirect()->route('account.changepw')->with('error-new-pw', __('title.error-new-password'));
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

    // function has not been used
    public function makeErrorList(Request $request)
    {
        // check $error
        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }

        return 0;
    }
}
