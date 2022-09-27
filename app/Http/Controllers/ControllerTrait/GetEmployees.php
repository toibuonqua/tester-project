<?php

namespace App\Http\Controllers\ControllerTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

trait GetEmployees
{
    /**
     * returnEmployees function
     *
     * @param [string] $email
     * @return boolean
     *
     * check email of user want to modify. If true you can fix it or false you can't do anything
     */
    public function returnEmployees($email)
    {
        $idBoss = Auth::id();
        $dataEm = DB::select("call get_users($idBoss)");
        $arrayem = array();
        foreach ($dataEm as $key => $value) {
            array_push($arrayem, $dataEm[$key]->employee);
        }
        return in_array($email, $arrayem);
    }
}
