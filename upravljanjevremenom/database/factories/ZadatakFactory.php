<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Zadatak;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zadatak>
 */
class ZadatakFactory extends Factory
{
    protected $model = Zadatak::class;
    public function definition(): array
    {
        return [
            'naslov' => $this->faker->sentence(3),
            'opis' => $this->faker->paragraph(),
            'uradjeno' => $this->faker->boolean(30), 
            'rok' => $this->faker->dateTimeBetween('now', '+1 month'),
            'korisnik_id' => User::factory(),

        ];
    }
}
