<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['author', 'categories'])->published()->latest()->paginate(10);
        return ArticleResource::collection($articles);
    }

    public function show(Article $article)
    {
        // Ensure it is published
        if ($article->status !== 'published') {
            abort(404);
        }

        $article->load(['author', 'categories']);

        return new ArticleResource($article);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'author_id' => Auth::id(),
            'status' => $request->status,
        ]);

        if ($request->has('categories')) {
            $article->categories()->attach($request->categories);
        }

        return (new ArticleResource($article))->response()->setStatusCode(201);
    }

    public function update(Request $request, $article)
    {
        // $article is the ID because SubstituteBindings is disabled for this route
        $articleModel = Article::findOrFail($article);

        // Authorization check (optional but good practice, though not explicitly requested)
        if ($articleModel->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:draft,published',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $data = $request->only(['title', 'content', 'status']);
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $articleModel->update($data);

        if ($request->has('categories')) {
            $articleModel->categories()->sync($request->categories);
        }

        return new ArticleResource($articleModel);
    }

    public function destroy($article)
    {
        // $article is the ID
        $articleModel = Article::findOrFail($article);

        if ($articleModel->author_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $articleModel->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }
}
