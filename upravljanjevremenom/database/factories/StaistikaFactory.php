<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statistika>
 */
class StaistikaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ukupno = $this->faker->numberBetween(1, 50);
        $odradjeni = $this->faker->numberBetween(0, $ukupno);

        return [
            'broj_odradjenih_zadataka' => $odradjeni,
            'ukupan_broj_zadataka' => $ukupno,
            'procenat_uspesnosti' => round(($odradjeni / $ukupno) * 100, 2),
            'korisnik_id' => UserFactory::factory(),

        ];
    }
}
