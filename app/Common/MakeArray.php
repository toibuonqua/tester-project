<?php

namespace App\Common;

use Illuminate\Http\Request;

trait MakeArray
{
    public function backArray($items, $array)
    {
        $itemsList = array();

        foreach ($items as $item) {
            array_push($itemsList, $this->makeObject($item, $array));
        }
        return $itemsList;
    }

    public function makeObject($item, $array)
    {
        $result = array();
        foreach ($array as $value) {
            array_push($result, $item->$value);
        }
        return $result;
    }
}
