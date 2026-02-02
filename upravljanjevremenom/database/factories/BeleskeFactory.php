<?php

namespace Database\Factories;

use App\Models\Beleske;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beleske>
 */
class BeleskeFactory extends Factory
{
    protected $model = Beleske::class;
    
    public function definition(): array
    {
        return [
            'naslov' => $this->faker->sentence(3),
            'sadrzaj' => $this->faker->paragraph(3),
            'korisnik_id' => User::factory(),

        ];
    }
}
