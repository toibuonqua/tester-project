<?php

namespace App\Exports;

use App\Models\Accounts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;


class AccountsExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $accounts = Accounts::with('role', 'department', 'workarea')->get();

        foreach ($accounts as $account) {
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };
        $exportArray = array();
        foreach ($accounts as $account) {
            array_push($exportArray, [
                $account->id,
                $account->username,
                $account->email,
                $account->department_name,
                $account->role_name,
                $account->workarea_code,
                $account->created_at,
                $account->updated_at,
            ]);
        }
        return $exportArray;
    }

    public function headings(): array
    {
        return ["ID", __('title.fullname'), "Email", __('title.department'), __('title.role'), __('title.work-area'), __('title.time_create'), __('title.time_update')];
    }
}

