<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(50)->create([
            'password' => bcrypt('password'), // password
        ]);
        User::find(1)->update([
            'name' => 'admin',
            'email' => 'summer@example.com',
            'password' => bcrypt('123456'),
            'is_admin' => true,
        ]);
    }
}
