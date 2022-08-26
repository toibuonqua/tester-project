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


class UsersManagementController extends Controller
{

    use WebResponseTrait, ExportExceptOnScreen;
    public function index(Request $request) {

        $accounts = Accounts::with('role', 'department','workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        foreach($accounts as $account){
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };

        return view('userManagement.usersmanagement', compact('accounts'));
    }

    public function add(Request $request) {
        $title = __('title.add-user');
        $departments = Department::all();
        $roles = Role::all();

        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }

        return view('userManagement.adduser', compact('title', 'departments', 'roles'));
    }

    public function modify($id) {

        $departments = Department::all();
        $roles = Role::all();

        $account = Accounts::with(['role', 'department'])->find($id);
        $workarea = Workarea::find($account->workarea_id);
        $title = __('title.modify-info-user');

        return view('userManagement.moduser', compact('title', 'account', 'workarea', 'departments', 'roles'));
    }

    public function detail($id) {

        $account = Accounts::find($id);
        $department = Department::find($account->department_id);
        $role = Role::find($account->role_id);
        $workarea = Workarea::find($account->workarea_id);
        $title = __('title.detail-user');

        return view('userManagement.detailuser', compact('title', 'account', 'department', 'workarea', 'role'));
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
        $account->save();
        return redirect()->route('homepage');
    }

    public function search(Request $request)
    {
        $search_text = $request->input("query");
        $accounts = Accounts::where('username', 'like', '%'.$search_text.'%')->with('role', 'department','workarea')->paginate(Accounts::DEFAULT_PAGINATION);

        foreach($accounts as $account){
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };


        return view('userManagement.usersmanagement', compact('accounts'));
    }

    public function active($id){
        $account = Accounts::find($id);

        if ($account->status === Accounts::STATUS_ACTIVATED) {
            $account->status = Accounts::STATUS_DEACTIVATED;
        } else {
            $account->status = Accounts::STATUS_ACTIVATED;
        }
        $account->save();

        return redirect()->route('homepage');
    }

    public function resetpw($id){
        $account = Accounts::find($id);
        $account->password = Accounts::DEFAULT_PASSWORD;
        $account->save();
        return redirect()->route('homepage');
    }

    public function changePassword(){

        return view('ChangePassword.changepassword');
    }

}
