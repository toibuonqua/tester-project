<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Common\MakeArray;


class AccountsExport implements FromArray, WithHeadings, ShouldAutoSize
{
    use MakeArray;

    public function __construct($accounts)
    {
        $result = $this->formatToArray($accounts, [
            'username',
            'email',
            'department_name',
            'role_name',
            'workarea_code',
            'created_at',
            'updated_at',
        ]);
        $this->accounts = $result;
    }

    public function array(): array
    {
        return $this->accounts;
    }

    public function headings(): array
    {
        return [
            __('title.fullname'),
            __('title.email'),
            __('title.department'),
            __('title.role'),
            __('title.work-area'),
            __('title.time_create'),
            __('title.time_update')
        ];
    }
}

