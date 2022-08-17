<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;

class UsersManagementController extends Controller
{

    public function index() {

        // $accounts[0]['name'];
        // $accounts[0]->name;

        $accounts = Accounts::all();

        return view('userManagement.usersmanagement', ['accounts' => $accounts]);
    }

    public function add() {
        $title = "Thêm Người Dùng";
        return view('userManagement.adduser', compact('title'));
    }

    public function modify($id) {

        $acc = Accounts::find($id);
        $title = "Sửa Thông Tin Người Dùng";
        return view('userManagement.moduser', compact('title', 'acc'));
    }

    public function detail($id) {

        $acc = Accounts::find($id);
        $title = "Chi Tiết Người Dùng";
        return view('userManagement.detailuser', compact('title', 'acc'));
    }

}
