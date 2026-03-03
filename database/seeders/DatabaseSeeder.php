<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\ServiceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@creativeup.com'],
            [
                'name' => 'Admin CreativeUP',
                'password' => bcrypt('password')
            ]
        );

        $this->call([
            ServiceSeeder::class,
            ProjectSeeder::class,
            PostSeeder::class,
        ]);
    }
}