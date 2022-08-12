<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersManagementController extends Controller
{

    public function viewUM() {
        $NavName = "Quản lý người dùng";
        return view('userManagement.usersmanagement', compact('NavName'));
    }

    public function viewAddUser() {
        $NavName = "Quản lý người dùng";
        $title = "Thêm Người Dùng";
        return view('userManagement.adduser', compact('NavName', 'title'));
    }

    public function viewModUser() {
        $NavName = "Quản lý người dùng";
        $title = "Sửa Thông Tin Người Dùng";
        return view('userManagement.moduser', compact('NavName', 'title'));
    }

    public function viewDetailUser() {
        $NavName = "Quản lý người dùng";
        $title = "Chi Tiết Người Dùng";
        return view('userManagement.detailuser', compact('NavName', 'title'));
    }

}
