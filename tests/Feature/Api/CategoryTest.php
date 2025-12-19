<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_returns_category_by_slug()
    {
        $category = Category::factory()->create([
            'name' => 'PHP',
            'slug' => 'php',
        ]);

        $response = $this->getJson('/categories/' . $category->slug);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $category->id,
                'name' => 'PHP',
                'slug' => 'php',
            ]);
    }
}
