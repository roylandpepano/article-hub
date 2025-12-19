<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_articles()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $category = Category::factory()->create(['name' => 'php']);
        $article = Article::factory()->create([
            'title' => 'Example Article',
            'slug' => 'example-article',
            'content' => 'Lorem ipsum...',
            'author_id' => $user->id,
            'status' => 'published',
        ]);
        $article->categories()->attach($category);

        $response = $this->getJson('/articles');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $article->id,
                'title' => 'Example Article',
                'slug' => 'example-article',
                'content' => 'Lorem ipsum...',
                'author' => 'John Doe',
                'status' => 'published',
                'categories' => ['php'],
            ]);
    }

    public function test_show_returns_article_by_slug()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $category = Category::factory()->create(['name' => 'php']);
        $article = Article::factory()->create([
            'title' => 'Example Article',
            'slug' => 'example-article',
            'content' => 'Lorem ipsum...',
            'author_id' => $user->id,
            'status' => 'published',
        ]);
        $article->categories()->attach($category);

        $response = $this->getJson('/articles/' . $article->slug);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $article->id,
                'title' => 'Example Article',
                'slug' => 'example-article',
                'content' => 'Lorem ipsum...',
                'author' => 'John Doe',
                'status' => 'published',
                'categories' => ['php'],
            ]);
    }

    public function test_store_creates_article()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $category = Category::factory()->create(['name' => 'php']);

        $this->actingAs($user);

        $articleData = [
            'title' => 'New Article',
            'content' => 'New Content',
            'status' => 'published',
            'categories' => [$category->id], // Assuming API accepts IDs or names? Usually IDs.
        ];

        $response = $this->postJson('/articles', $articleData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('articles', ['title' => 'New Article']);

        // Check response format
        $response->assertJsonStructure([
            'id', 'title', 'slug', 'content', 'author', 'status', 'categories', 'created_at'
        ]);
    }

    public function test_update_updates_article_by_id()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $article = Article::factory()->create([
            'author_id' => $user->id,
            'title' => 'Old Title',
        ]);

        $this->actingAs($user);

        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'status' => 'published',
        ];

        $response = $this->putJson('/articles/' . $article->id, $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('articles', ['id' => $article->id, 'title' => 'Updated Title']);

        $response->assertJson([
            'title' => 'Updated Title',
        ]);
    }

    public function test_destroy_deletes_article_by_id()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['author_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->deleteJson('/articles/' . $article->id);

        $response->assertStatus(200); // or 204
        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }
}
