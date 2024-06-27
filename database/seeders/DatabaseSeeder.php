<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        $userData = [
            ['name' => 'Odon3', 'email' => 'odon3@lanahospital.com'],
            ['name' => 'Prime', 'email' => 'peace9917@gmail.com'],
            ['name' => 'Gift', 'email' => 'onuezegift@gmail.com'],
        ];
        
        foreach ($userData as $data) {
            User::factory()->create($data);
        }
        
        $this->call(GroupsTableSeeder::class);
        $this->call(BirthdayTemplatesSeeder::class);
    }
}
