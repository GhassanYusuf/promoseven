<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

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

        $faker = Faker::create();

        return [
            'name' => $faker->name(),
            'accesslevel' => $faker->randomElement(['A', 'H', 'M', 'S', 'E']),
            'rfid' => $faker->numerify('##########'),
            'zktid' => null,
            'code' => null,
            'position' => rand(1, 5),
            'contact' => '+'.str_pad(rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT),
            'company' => rand(1, 25),
            'cpr' => $faker->numerify('##########'),
            'cpr_expire' => $faker->date(),
            'passport' => $faker->numerify('##########'),
            'passport_expire' => $faker->date(),
            'visa' => null,
            'visa_expire' => null,
            'nationality' => rand(1, 239),
            'gender' => $faker->randomElement(['M', 'F']),
            'birthdate' => $faker->date(),
            'join_date' => $faker->date(),
            'end_date' => null,
            'bank_account' => $faker->numerify('##########'),
            'picture' => null,
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt(Str::random(10)), // Replace with a more secure password hashing method
            'remember_token' => Str::random(10), // Use Str::random() within the Factory
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
