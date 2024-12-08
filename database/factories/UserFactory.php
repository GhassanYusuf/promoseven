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
            'name' => $this->faker->name(),
            'rfid' => $this->faker->unique()->regexify('[a-zA-Z0-9]{10}'),
            'code' => $this->faker->unique()->regexify('[a-zA-Z0-9]{10}'),
            'contact' => [
                'phone' => $this->faker->phoneNumber(),
                'email' => $this->faker->safeEmail(),
            ],
            'qualifications' => $this->faker->sentence(),
            'cpr' => $this->faker->regexify('[0-9]{10}'),
            'passport' => $this->faker->regexify('[a-zA-Z0-9]{30}'),
            'nationality' => $this->faker->randomElement(['EG', 'SA', 'US']),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'birthdate' => $this->faker->date(),
            'bank_account' => $this->faker->regexify('[a-zA-Z0-9]{100}'),
            'picture' => $this->faker->imageUrl(100, 100),
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
