<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_category_page()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category));

        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
        $response->assertViewHas('category', $category);
    }

    public function test_category_page_shows_published_articles()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $publishedArticle = Article::factory()->create([
            'author_id' => $user->id,
            'status' => 'published',
        ]);
        $publishedArticle->categories()->attach($category);

        $draftArticle = Article::factory()->create([
            'author_id' => $user->id,
            'status' => 'draft',
        ]);
        $draftArticle->categories()->attach($category);

        $response = $this->get(route('categories.show', $category));

        $response->assertStatus(200);
        $response->assertSee($publishedArticle->title);
        $response->assertDontSee($draftArticle->title);
    }
}
