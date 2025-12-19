<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Category::create(['name' => 'Technology', 'slug' => 'technology']);
        Category::create(['name' => 'Health', 'slug' => 'health']);
        Category::create(['name' => 'Science', 'slug' => 'science']);
        Category::create(['name' => 'Lifestyle', 'slug' => 'lifestyle']);
    }
}
