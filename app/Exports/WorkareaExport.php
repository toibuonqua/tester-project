<?php

namespace App\Exports;

use App\Models\Workarea;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Common\MakeArray;

class WorkareaExport implements FromArray, WithHeadings
{
    use MakeArray;

    public function __construct($workareas)
    {
        $result = $this->backArray($workareas, [
            'work_areas_code',
            'name',
            'created_at',
            'updated_at',
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
            __('title.time_create'),
            __('title.time_update'),
        ];
    }

}
