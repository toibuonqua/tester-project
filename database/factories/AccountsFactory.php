<?php

namespace Database\Factories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Role;
use App\Models\Department;
use App\Models\Workarea;
use App\Models\Accounts;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accounts>
 */
class AccountsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $workareas = Workarea::pluck('id')->toArray();
        $departments = Department::pluck('id')->toArray();
        $role_admin = Role::whereNot('name', Accounts::TYPE_ADMIN)->pluck('id')->toArray();
        $admin = Accounts::where('email', 'admin@gmail.com')->first();
        return [
            'email' => $this->faker->unique()->email(),
            'password' => Hash::make("12345678"),
            'username' => $this->faker->name(),
            'status' => Arr::random([Accounts::STATUS_DEACTIVATED, Accounts::STATUS_ACTIVATED]),
            'role_id' => Arr::random($role_admin),
            'workarea_id' => Arr::random($workareas),
            'code_user' => $this->faker->unique()->numberBetween(1001, 9999),
            'phone_number' => $this->faker->phoneNumber(),
            'manager_id' => $admin->id,
            'department_id' => Arr::random($departments),
        ];
    }
}
