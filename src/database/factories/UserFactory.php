<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $kanaName = $this->faker->kanaName();

        return [
            'name' => $kanaName,
            'kana_name' => $kanaName,
            'birth_date' => $this->faker->date(),
            'avatar' => $this->faker->imageUrl(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '0' . random_int(1, 9) . '0-0000-000' . random_int(0, 9),
            'zipcode' => fake()->postcode(),
            'pref' => fake()->numberBetween(1, 47),
            'city' => fake()->city(),
            'street' => fake()->streetAddress(),
            'remarks' => $this->faker->realText(50, 5),
            'email_verified_at' => now(),
            'password' => bcrypt(Str::random(16)), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
