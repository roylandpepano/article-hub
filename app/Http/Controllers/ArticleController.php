<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['author', 'categories'])->published()->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $articles = Article::with(['author', 'categories'])
            ->published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(10);

        $articles->appends(['q' => $query]);

        return view('articles.index', compact('articles'));
    }

    public function myArticles()
    {
        $articles = Article::where('author_id', Auth::id())->latest()->paginate(10);
        return view('articles.my_articles', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'author_id' => Auth::id(),
            'status' => $request->status,
        ]);

        if ($request->has('category_ids')) {
            $article->categories()->attach($request->category_ids);
        }

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        $article->load('author', 'categories');
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        // Ensure only the author can edit
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'category_ids' => 'array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'status' => $request->status,
        ]);

        $article->categories()->sync($request->input('category_ids', []));

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
