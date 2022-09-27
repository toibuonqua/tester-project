<?php

namespace Database\Seeders;

use App\Models\Workarea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Workarea::factory(10)->create([
            'createrId' => 1
        ]);
    }
}
