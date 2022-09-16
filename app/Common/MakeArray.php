<?php

namespace App\Common;

use Illuminate\Http\Request;

trait MakeArray
{
    /**
     * documented function formatArray()
     *
     * @param data [type] $items -> example: $items = Model::all();
     * @param array [type] $column_array ->example: $column_array = ['column_name_data', 'column_name_data', 'column_name_data', . . .]
     * @return array() example: [$column_array, $column_array, . . . ]
     *
     */
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
