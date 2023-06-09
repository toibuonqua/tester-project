<?php

namespace Database\Seeders;

use App\Models\Accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Workarea;
use App\Models\Department;
use Illuminate\Support\Arr;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workareas = Workarea::pluck('id')->toArray();
        $departments = Department::pluck('id')->toArray();
        $admin_role = Role::where('name', Accounts::TYPE_ADMIN)->first();
        Accounts::create(
            [
                'username' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'status' => Accounts::STATUS_ACTIVATED,
                'role_id' => $admin_role->id,
                'workarea_id' => Arr::random($workareas),
                'code_user' => 1000,
                'phone_number' => "123-456-789",
                'manager_id' => null,
                'department_id' => Arr::random($departments),
            ]
        );

        Accounts::factory(50)->create();
    }
}
