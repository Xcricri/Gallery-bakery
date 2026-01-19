<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gallery;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GallerySeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Fahcri Muhammad Nur Ilham',
            'role' => 'admin',
            'email' => 'fahcri@gmail.com',
            'password'=> Hash::make('fahcri12345'),
        ]);

        User::factory(20)->create([
            'role' => 'member',
            'password'=> Hash::make('pasword12345'),
        ]);

        $this->call([
            CategorySeeder::class,
        ]);
    }
}
