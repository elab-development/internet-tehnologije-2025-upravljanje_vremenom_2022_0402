<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obavestenje>
 */
class ObavestenjeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'poruka' => $this->faker->sentence(8),
            'poslato' => $this->faker->dateTimeBetween('-2 days', 'now'),
            'nacin_slanja' => $this->faker->randomElement([
                'email',
                'aplikacija',
                'sms'
            ]),
            'korisnik_id' => UserFactory::factory(),

        ];
    }
}
