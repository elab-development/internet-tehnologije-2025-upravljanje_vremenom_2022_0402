<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Podsetnik>
 */
class PodsetnikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vreme' => $this->faker->dateTimeBetween('now', '+7 days'),
            'aktivan' => $this->faker->boolean(80), 
            'korisnik_id' => UserFactory::factory(),

        ];
    }
}
