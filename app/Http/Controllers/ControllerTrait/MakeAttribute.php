<?php

namespace App\Http\Controllers\ControllerTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

trait MakeAttribute
{
    /**
     *
     * addAttribute function
     *
     * @param [data model type] $items
     * @param [array type] $fields
     * @return data model with new attribute
     *
     */
    public function addAttribute($items, $fields)
    {
        foreach ($items as $item) {
            foreach ($fields as $key => $value) {
                $value_arr = explode(".", $value);
                $val_1 = $value_arr[0];
                $val_2 = $value_arr[1];
                $item->$key = $item->$val_1->$val_2;
            }
        }
        return $items;
    }
}
