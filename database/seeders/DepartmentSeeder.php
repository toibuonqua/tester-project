<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['name' => 'Quản Lý'],
            ['name' => 'Nhân Sự'],
            ['name' => 'Công Nghệ'],
            ['name' => 'Dịch Vụ'],
            ['name' => 'Tạp Vụ'],
            ['name' => 'Sửa Chữa'],
            ['name' => 'Bảo Vệ'],
        ];

        foreach ($departments as $key => $value) {
            Department::create($value);
        }
    }
}
