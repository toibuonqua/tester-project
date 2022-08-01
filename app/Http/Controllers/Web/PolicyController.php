<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    use WebResponseTrait;

    public function showPolicy(Request $request)
    {
        return response()->view('policy');
    }
}
