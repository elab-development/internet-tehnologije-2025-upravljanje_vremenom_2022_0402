<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Zadatak;
use App\Models\Beleske;
use App\Models\Podsetnik;
use App\Models\Obavestenje;
use App\Models\Statistika;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(5)->create([
            'tip' => 'regular',
        ]);
        User::factory()->count(2)->create([
            'tip' => 'premium',
        ]);
        User::factory()->count(1)->create([
            'tip' => 'admin',
        ]);

        User::all()->each(function ($user) {
            Zadatak::factory()->count(5)->create([
                'korisnik_id' => $user->id,
            ]);
            Beleske::factory()->count(3)->create([
                'korisnik_id' => $user->id,
            ]);
            Podsetnik::factory()->count(2)->create([
                'korisnik_id' => $user->id,
            ]);
            Obavestenje::factory()->count(4)->create([
                'korisnik_id' => $user->id,
            ]);
          Statistika::factory()->create([
                'korisnik_id' => $user->id,
            ]);
       });

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
