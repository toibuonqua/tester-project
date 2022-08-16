<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersManagementController extends Controller
{

    public function viewUM() {

        // $accounts[0]['name'];
        // $accounts[0]->name;

        $accounts = [
            new Account([
                'name' => 'Mark Quinn',
                'email' => 'abc@gmail.com',
                'email_verified_at' => '2022-08-16 10:00:00',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => 'dasdasd',
            ]),
            new Account([
                'name' => 'thanhCV',
                'email' => '@def@gmail.com',
                'email_verified_at' => '2022-08-16 10:00:00',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => 'sdasdasdas',
            ]),
            new Account([
                'name' => 'TienMA',
                'email' => '@def@gmail.com',
                'email_verified_at' => '2022-08-16 10:00:00',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => 'sdasdasdas',
            ]),
            new Account([
                'name' => 'TienNT',
                'email' => '@def@gmail.com',
                'email_verified_at' => '2022-08-16 10:00:00',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => 'sdasdasdas',
            ])
            ];

        $accounts = Account::factory

        return view('userManagement.usersmanagement', ['accounts' => $accounts]);
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
