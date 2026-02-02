<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zadatak>
 */
class ZadatakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'naslov' => $this->faker->sentence(3),
            'opis' => $this->faker->paragraph(),
            'uradjeno' => $this->faker->boolean(30), 
            'rok' => $this->faker->dateTimeBetween('now', '+1 month'),
            'korisnik_id' => UserFactory::factory(),

        ];
    }
}
