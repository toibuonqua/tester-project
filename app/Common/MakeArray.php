<?php

namespace App\Common;

use Illuminate\Http\Request;

trait MakeArray
{
    // Hàm nhận vào 2 parameter [$items (data query từ database), $array (phần tử là tên các cột trong items).
    // return => 1 array với các phần từ là các object.
    // VD: $result = backArray($data, ['column_name_data', 'column_name_data', 'column_name_data', . . .])
    public function formatToArray($items, $column_array)
    {
        $itemsList = array();

        foreach ($items as $item) {
            array_push($itemsList, $this->makeObject($item, $column_array));
        }
        return $itemsList;
    }

    public function makeObject($item, $column_array)
    {
        $result = array();
        foreach ($column_array as $value) {
            array_push($result, $item->$value);
        }
        return $result;
    }
}
