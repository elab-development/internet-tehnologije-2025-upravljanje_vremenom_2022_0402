<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beleške>
 */
class BeleskeFactory extends Factory
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
            'sadrzaj' => $this->faker->paragraph(3),
            'korisnik_id' => UserFactory::factory(),

        ];
    }
}
