<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewArrivalManagementController extends Controller
{
    public function index() {

        return view('newArrivalManagement.newarrivalmanagement');
    }
}
