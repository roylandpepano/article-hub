<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'author_id' => Auth::id(),
            'status' => 'published',
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        // Ensure only the author can edit
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->author_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ]);

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
