<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeTableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'day' => $this->faker->randomElement(['mon', 'tue', 'wed', 'thu', 'fri']),
            'time_start' => $this->faker->time("H:i"),
            'time_end' => $this->faker->time("H:i"),
            'class_no' => $this->faker->randomElement(['A', 'B', 'C', 'D']) . '-' . $this->faker->unique()->numberBetween('206', '309'),
            'course_id' => $this->faker->randomElement(Course::pluck('id')->toArray())
        ];
    }
}
