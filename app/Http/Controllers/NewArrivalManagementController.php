<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewArrivalManagementController extends Controller
{
    public function index() {
        $NavName = 'Quản lý hàng mới về';
        return view('newArrivalManagement.newarrivalmanagement', compact('NavName'));
    }
}
