<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersManagementController extends Controller
{

    public function viewUM() {

        return view('userManagement.usersmanagement');
    }

    public function viewAddUser() {
        $title = "Thêm Người Dùng";
        return view('userManagement.adduser', compact('title'));
    }

    public function viewModUser() {
        $title = "Sửa Thông Tin Người Dùng";
        return view('userManagement.moduser', compact('title'));
    }

    public function viewDetailUser() {
        $title = "Chi Tiết Người Dùng";
        $unknown = "Unknown";
        return view('userManagement.detailuser', compact('title'));
    }

}
