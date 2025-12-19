<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_articles_by_title()
    {
        $user = User::factory()->create();

        Article::factory()->create([
            'title' => 'Laravel Search Functionality',
            'content' => 'Content about searching.',
            'status' => 'published',
            'author_id' => $user->id,
        ]);

        Article::factory()->create([
            'title' => 'Another Article',
            'content' => 'Content about something else.',
            'status' => 'published',
            'author_id' => $user->id,
        ]);

        $response = $this->get('/articles/search?q=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel Search Functionality');
        $response->assertDontSee('Another Article');
    }

    public function test_search_articles_by_content()
    {
        $user = User::factory()->create();

        Article::factory()->create([
            'title' => 'Hidden Gem',
            'content' => 'This article contains the secret keyword.',
            'status' => 'published',
            'author_id' => $user->id,
        ]);

        Article::factory()->create([
            'title' => 'Plain Article',
            'content' => 'Just some random text.',
            'status' => 'published',
            'author_id' => $user->id,
        ]);

        $response = $this->get('/articles/search?q=secret');

        $response->assertStatus(200);
        $response->assertSee('Hidden Gem');
        $response->assertDontSee('Plain Article');
    }

    public function test_filter_articles_by_category()
    {
        $user = User::factory()->create();
        $category1 = \App\Models\Category::factory()->create(['name' => 'Tech']);
        $category2 = \App\Models\Category::factory()->create(['name' => 'Life']);

        $article1 = Article::factory()->create([
            'title' => 'Tech Article',
            'status' => 'published',
            'author_id' => $user->id,
        ]);
        $article1->categories()->attach($category1);

        $article2 = Article::factory()->create([
            'title' => 'Life Article',
            'status' => 'published',
            'author_id' => $user->id,
        ]);
        $article2->categories()->attach($category2);

        $response = $this->get('/articles/search?category=' . $category1->id);

        $response->assertStatus(200);
        $response->assertSee('Tech Article');
        $response->assertDontSee('Life Article');
    }
}
