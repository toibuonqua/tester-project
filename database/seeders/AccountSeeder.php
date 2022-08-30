<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use App\Models\Accounts;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts =[ 
            [
                'username' => 'TienMA',
                'email' => 'tienma@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'active',
                'role_id' => 1,
                'workarea_id' => 1,
                'code_user' => 1002,
                'phone_number' => 19001900,
                'manager_id' => 1,
                'department_id' => 1,
            ],
            [
                'username' => 'TienNN',
                'email' => 'tiennn@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'active',
                'role_id' => 1,
                'workarea_id' => 1,
                'code_user' => 1002,
                'phone_number' => 19001900,
                'manager_id' => 1,
                'department_id' => 1,
            ]
        ];
    }
}
