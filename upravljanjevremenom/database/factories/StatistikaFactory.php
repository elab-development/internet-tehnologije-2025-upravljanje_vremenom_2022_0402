<?php

namespace Database\Factories;

use App\Models\Statistika;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statistika>
 */
class StatistikaFactory extends Factory
{
    protected $model = Statistika::class;
    public function definition(): array
    {
        $ukupno = $this->faker->numberBetween(1, 50);
        $odradjeni = $this->faker->numberBetween(0, $ukupno);

        return [
            'broj_odradjenih_zadataka' => $odradjeni,
            'ukupan_broj_zadataka' => $ukupno,
            'procenat_uspesnosti' => round(($odradjeni / $ukupno) * 100, 2),
            'korisnik_id' => User::factory(),

        ];
    }
}
