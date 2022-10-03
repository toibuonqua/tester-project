<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Common\MakeArray;

class DepartmentExport implements FromArray, WithHeadings, ShouldAutoSize
{
    use MakeArray;

    public function __construct($departments)
    {
        $result = $this->formatToArray($departments, [
            'name',
            'created_at',
            'updated_at',
        ]);
        $this->departments = $result;
    }

    public function array(): array
    {
        return $this->departments;
    }

    public function headings(): array
    {
        return [
            __('title.department'),
            __('title.time_create'),
            __('title.time_update')
        ];
    }
}
