<?php

namespace App\Exports;

use App\Models\Workarea;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Common\MakeArray;

class WorkareaExport implements FromArray, WithHeadings, ShouldAutoSize
{
    use MakeArray;

    public function __construct($workareas)
    {
        $result = $this->formatToArray($workareas, [
            'work_areas_code',
            'name',
            'creater',
            'created_at',
        ]);
        $this->workareas = $result;
    }

    public function array(): array
    {
        return $this->workareas;
    }

    public function headings(): array
    {
        return [
            __('title.code-work-area'),
            __('title.name-work-area'),
            __('title.creater'),
            __('title.time_create'),
        ];
    }

}
