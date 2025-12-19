@extends('layout.app')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Category: <span class="text-indigo-600">{{ $category->name }}</span></h1>
        <a href="{{ route('articles.index') }}" class="text-xs font-medium text-slate-500 hover:text-indigo-600 transition-colors flex items-center gap-1">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Articles
        </a>
    </div>

    <div class="grid gap-4">
        @foreach($articles as $article)
            <article class="bg-white p-5 rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="text-lg font-semibold text-slate-800 leading-tight">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-indigo-600 transition-colors">{{ $article->title }}</a>
                    </h2>
                </div>

                <div class="text-xs text-slate-400 mb-3 flex items-center gap-2">
                    <span>{{ $article->author->name }}</span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span>{{ $article->created_at->format('M d, Y') }}</span>
                </div>

                <p class="text-slate-600 mb-4 text-sm leading-relaxed line-clamp-2">{{ Str::limit($article->content, 150) }}</p>

                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                    <a href="{{ route('articles.show', $article) }}" class="text-xs font-medium text-indigo-500 hover:text-indigo-600 transition-colors flex items-center gap-1">
                        <i class="fa-solid fa-book-open mr-1"></i> Read article
                    </a>
                </div>
            </article>
        @endforeach

        @if($articles->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl border border-slate-100 border-dashed">
                <p class="text-slate-400 text-sm">No articles found in this category.</p>
            </div>
        @endif
    </div>
</div>
@endsection
