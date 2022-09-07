<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Workarea;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workarea>
 */
class WorkareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'KVLV'.$this->faker->unique()->numberBetween(1, 99),
            'work_areas_code' => 'KV00'.$this->faker->unique()->numberBetween(1, 99),
            'status' => Workarea::DEFAULT_STATUS,
        ];
    }
}
