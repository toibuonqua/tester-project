<?php

namespace Database\Seeders;

use App\Models\SystemConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemConfig::create(
            [
                'password' => SystemConfig::DEFAULT_PASSWORD,
            ]
        );
    }
}
