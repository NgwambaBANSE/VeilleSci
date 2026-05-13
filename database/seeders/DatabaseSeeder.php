<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Administrateur
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@veille.local',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        // Utilisateur test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);
    }
}
