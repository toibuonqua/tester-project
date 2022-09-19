<?php

namespace Database\Seeders;

use App\Models\DefaultPassword;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultPassword::create(
            [
                'password' => '12345678',
            ]
        );
    }
}
