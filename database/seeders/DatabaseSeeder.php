<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin user',
            'email' => 'admin@example.com',
            'password' => 'Aa123456!',
        ]);

        User::create([
            'name' => 'mod user',
            'email' => 'mod@example.com',
            'password' => 'Aa123456!',
        ]);


        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => 'Aa123456!',
        ]);

        User::factory(1000)->create();
        Post::factory(5000)->create();

    }
}
