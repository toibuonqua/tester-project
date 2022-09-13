<?php

namespace App\Exports;

use App\Models\Workarea;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkareaExport implements FromArray, WithHeadings
{

    public function __construct($workareas)
    {
        $this->workareas = $workareas;
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
