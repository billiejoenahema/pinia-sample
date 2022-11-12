<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'working_date' => now(),
            'in_time' => Carbon::parse('09:00')->format('H:i'),
            'out_time' =>  Carbon::parse('18:00')->format('H:i'),
            'rest_time' => Carbon::parse('01:00')->format('H:i'),
        ];
    }
}
