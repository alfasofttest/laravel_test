<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'contact' => $this->faker->numerify('#########'),
            'email' => $this->faker->unique()->email(),
        ];
    }

    public function deleted(): ContactFactory
    {
        return $this->state(function () {
            return [
                'deleted_at' => now()
            ];
        });
    }
}
