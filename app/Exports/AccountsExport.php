<?php

namespace App\Exports;

use App\Models\Accounts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;


class AccountsExport implements FromArray, WithHeadings
{

    public function __construct($accounts)
    {
        $this->accounts = $accounts;
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

