<?php

namespace App\Common;

class TransformList
{
    private $list;
    public function __construct($inputList)
    {
        $this->list = $inputList;
    }

    public function transformList($mapFuncs)
    {
        foreach ($mapFuncs as $func) {
            $this->list = array_map($func, $this->list);
        }
        return $this;
    }

    public function filterList($filterFuncs)
    {
        foreach ($filterFuncs as $func) {
            $this->list = array_filter($this->list, $func);
        }
        return $this;
    }

    public function getList()
    {
        return $this->list;
    }
}
