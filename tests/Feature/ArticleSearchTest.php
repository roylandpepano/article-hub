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
}
