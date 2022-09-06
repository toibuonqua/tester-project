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
            ['name' => 'Phòng ban A'],
            ['name' => 'Phòng ban B'],
            ['name' => 'Phòng ban C'],
            ['name' => 'Phòng ban D'],
            ['name' => 'Phòng ban E'],
            ['name' => 'Phòng ban F'],
            ['name' => 'Phòng ban G'],
        ];

        foreach ($departments as $key => $value) {
            Department::create($value);
        }
    }
}
