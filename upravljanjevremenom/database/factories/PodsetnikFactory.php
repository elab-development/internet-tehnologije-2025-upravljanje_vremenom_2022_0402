<?php

namespace Database\Factories;

use App\Models\Podsetnik;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Podsetnik>
 */
class PodsetnikFactory extends Factory
{
    protected $model = Podsetnik::class;
    public function definition(): array
    {
        return [
            'vreme' => $this->faker->dateTimeBetween('now', '+7 days'),
            'aktivan' => $this->faker->boolean(80), 
            'korisnik_id' => User::factory(),

        ];
    }
}
