<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();
        $this->call([
            UsersTableSeeder::class,
            StatusesTableSeeder::class,
            FollowersTableSeeder::class,
            // Add other seeders here if needed
        ]);

        Model::reguard();
    }
}
