<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_filter_my_articles_by_category()
    {
        $user = User::factory()->create();
        $category1 = Category::factory()->create(['name' => 'Tech']);
        $category2 = Category::factory()->create(['name' => 'Life']);

        $article1 = Article::factory()->create([
            'title' => 'Tech Article',
            'author_id' => $user->id,
        ]);
        $article1->categories()->attach($category1);

        $article2 = Article::factory()->create([
            'title' => 'Life Article',
            'author_id' => $user->id,
        ]);
        $article2->categories()->attach($category2);

        $response = $this->actingAs($user)->get('/my-articles?category=' . $category1->id);

        $response->assertStatus(200);
        $response->assertSee('Tech Article');
        $response->assertDontSee('Life Article');
    }

    public function test_user_can_filter_my_articles_by_status()
    {
        $user = User::factory()->create();

        Article::factory()->create([
            'title' => 'Published Article',
            'status' => 'published',
            'author_id' => $user->id,
        ]);

        Article::factory()->create([
            'title' => 'Draft Article',
            'status' => 'draft',
            'author_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/my-articles?status=published');

        $response->assertStatus(200);
        $response->assertSee('Published Article');
        $response->assertDontSee('Draft Article');
    }
}
