<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkSpaceManagementController extends Controller
{
    public function index() {
        return view('workSpaceManagement.workspacemanagement');
    }
}
