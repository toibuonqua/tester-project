<?php

namespace Database\Seeders;

use App\Models\Accounts;
use App\Models\Admincodestar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Workarea;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AdmincodestarSeeder extends Seeder
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
        Admincodestar::create([

            'username' => Admincodestar::DEFAULT_USERNAME,
            'email' => Admincodestar::DEFAULT_EMAIL,
            'password' => Hash::make(Admincodestar::DEFAULT_PASSWORD),
            'status' => Admincodestar::DEFAULT_STATUS,
            'role_id' => $admin_role->id,
            'workarea_id' => Arr::random($workareas),
            'code_user' => Admincodestar::DEFAULT_CODE_USER,
            'phone_number' => Admincodestar::DEFAULT_PHONE_NUMBER,
            'manager_id' => null,
            'department_id' => Arr::random($departments),

        ]);
    }
}
