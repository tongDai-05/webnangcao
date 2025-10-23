<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
{
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('123456'),
        'role' => 'admin',
    ]);

    \App\Models\User::create([
        'name' => 'User',
        'email' => 'user@gmail.com',
        'password' => bcrypt('123456'),
        'role' => 'user',
    ]);
    \App\Models\Book::factory(10)->create();
}

}
