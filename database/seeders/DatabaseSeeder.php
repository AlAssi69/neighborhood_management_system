<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@local.test'],
            ['name' => 'المسؤول', 'password' => bcrypt('password')],
        );

        $this->call(NeighborhoodSeeder::class);
    }
}
