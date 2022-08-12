<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkSpaceManagementController extends Controller
{
    public function index() {
        $NavName = 'Quản lý khu làm việc';
        return view('workSpaceManagement.workspacemanagement', compact('NavName'));
    }
}
