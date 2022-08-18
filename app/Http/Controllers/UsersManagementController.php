<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Work_area;


class UsersManagementController extends Controller
{

    public function index() {

        // $accounts[0]['name'];
        // $accounts[0]->name;

        $accounts = Accounts::all();
        $departments = Department::with('accounts')->get();
        $roles = Role::with('accounts')->get();
        $workareas = Work_area::with('accounts')->get();
        dd($departments);

        return view('userManagement.usersmanagement', compact('accounts', 'departments', 'roles', 'workareas'));
    }

    public function add() {
        $title = "Thêm Người Dùng";
        return view('userManagement.adduser', compact('title'));
    }

    public function modify($id) {

        $acc = Accounts::find($id);
        $department = Department::find($acc->department_id);
        $role = Role::find($acc->role_id);
        $workarea = Work_area::find($acc->workarea_id);
        $title = 'Sửa thông tin người dùng';

        return view('userManagement.moduser', compact('title', 'acc', 'department', 'workarea', 'role'));
    }

    public function detail($id) {

        $acc = Accounts::find($id);
        $department = Department::find($acc->department_id);
        $role = Role::find($acc->role_id);
        $workarea = Work_area::find($acc->workarea_id);
        $title = "Chi Tiết Người Dùng";

        return view('userManagement.detailuser', compact('title', 'acc', 'department', 'workarea', 'role'));
    }

}
