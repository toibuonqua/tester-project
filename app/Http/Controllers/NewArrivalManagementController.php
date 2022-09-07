<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewArrivalManagementController extends Controller
{
    public function index() {
        return view('newArrivalManagement.newarrivalmanagement');
    }
}
