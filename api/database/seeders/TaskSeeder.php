<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Faker\Generator as Faker;

class TaskSeeder extends Seeder
{
    public function run(Faker $faker): void
    {
        Task::factory()->count(10)->create([
            'title' => $faker->sentence,  
            'description' => $faker->paragraph,  
            'status' => $faker->randomElement(['pending', 'done']), 
        ]);
    }
}

