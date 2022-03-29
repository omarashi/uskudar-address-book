<?php

namespace Database\Factories;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $image = $this->faker->image(null, 240, 240, 'people', true);
        return [
            'f_name' => $this->faker->firstName(),
            'l_name' => $this->faker->lastName(),
            'ref_no' => 'LEC-' . Carbon::make($this->faker->unique()->dateTime)->timestamp,
            'department_id' => $this->faker->randomElement(Department::pluck('id')->toArray()),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->phoneNumber,
            'office_no' => $this->faker->randomElement(['A', 'B', 'C', 'D']) . '-' . $this->faker->unique()->numberBetween('206', '309'),
            'office_hours_start' => $this->faker->time('H:i', '10:00'),
            'office_hours_end' => $this->faker->time('H:i', '17:00'),
            'avatar' => \Storage::disk('public')->putFile('users', $image),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
