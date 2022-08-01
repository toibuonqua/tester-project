<?php

namespace App\Common;

use App\Imports\BasicImport;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImporter
{
    protected static function defaultOption()
    {
        return [
            'singleSheet' => True,
            'model' => new BasicImport,
        ];
    }

    public function __construct($options)
    {
        $this->options = array_merge(self::defaultOption(), $options);
    }

    public function loadFile($file)
    {
        $acceptOptions = array_merge(self::defaultOption(), $this->options);

        $result = Excel::toArray($acceptOptions['model'], $file);

        if ($acceptOptions['singleSheet']) {
            $this->data = $result[0];
        } else {
            $this->data = $result;
        }

        return $this;
    }

    public static function create($options = [])
    {
        return new self($options);
    }

    public function format($formater)
    {
        $this->data = $formater->format($this->data);
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}
