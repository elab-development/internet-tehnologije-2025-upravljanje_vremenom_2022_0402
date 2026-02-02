<?php

namespace Database\Factories;

use App\Models\Obavestenje;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obavestenje>
 */
class ObavestenjeFactory extends Factory
{
    protected $model = Obavestenje::class;
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
            'korisnik_id' => User::factory(),

        ];
    }
}
