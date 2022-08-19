<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Workarea;


class UsersManagementController extends Controller
{

    public function index() {

        // $accounts[0]['name'];
        // $accounts[0]->name;

        $accounts = Accounts::all();
        $departments = Department::with('accounts')->get();
        $roles = Role::with('accounts')->get();
        $workareas = Workarea::with('accounts')->get();

        return view('userManagement.usersmanagement', compact('accounts', 'departments', 'roles', 'workareas'));
    }

    public function add() {
        $title = "Thêm Người Dùng";
        $departments = Department::all();
        $roles = Role::all();
        return view('userManagement.adduser', compact('title', 'departments', 'roles'));
    }

    public function modify($id) {

        $departments = Department::all();
        $roles = Role::all();

        $account = Accounts::with(['role', 'department'])->find($id);
        // $department = Department::find($account->department_id);
        // $role = Role::find($account->role_id);
        $workarea = Workarea::find($account->workarea_id);
        $title = 'Sửa thông tin người dùng';

        return view('userManagement.moduser', compact('title', 'account', 'workarea', 'departments', 'roles'));
    }

    public function detail($id) {

        $account = Accounts::find($id);
        $department = Department::find($account->department_id);
        $role = Role::find($account->role_id);
        $workarea = Workarea::find($account->workarea_id);
        $title = "Chi Tiết Người Dùng";

        return view('userManagement.detailuser', compact('title', 'account', 'department', 'workarea', 'role'));
    }

    public function update($id, Request $request)
    {
        $account = Accounts::query()->findOrFail($id);
        $data = $request->only('username', 'email', 'phone_number', 'code_user');
        $account->update($data);

        return redirect()->route('homepage');
    }

}
