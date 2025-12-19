@extends('layout.app')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <div class="mb-8 border-b border-slate-50 pb-6">
        <h1 class="text-2xl font-bold text-slate-800 mb-3 tracking-tight">{{ $article->title }}</h1>
        <div class="text-xs text-slate-400 flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-1">
                <span class="font-medium text-slate-600">{{ $article->author->name }}</span>
            </div>
            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
            <span>{{ $article->created_at->format('F d, Y') }}</span>

            @if($article->categories->count() > 0)
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <div class="flex gap-1">
                    @foreach($article->categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded text-[10px] font-medium hover:bg-indigo-100 transition-colors uppercase tracking-wider">
                            <i class="fa-solid fa-tag mr-1"></i> {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="prose prose-slate prose-sm max-w-none mb-10 text-slate-600 leading-relaxed">
        {!! nl2br(e($article->content)) !!}
    </div>

    <div class="flex items-center justify-between border-t border-slate-50 pt-6">
        <a href="{{ route('articles.index') }}" class="text-xs font-medium text-slate-500 hover:text-indigo-600 transition-colors flex items-center gap-1">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Articles
        </a>

        @auth
            @if(auth()->id() === $article->author_id)
                <div class="flex gap-2">
                    <a href="{{ route('articles.edit', $article) }}" class="bg-amber-50 text-amber-600 px-3 py-1.5 rounded-lg hover:bg-amber-100 transition-colors text-xs font-medium">
                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                    </a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-rose-50 text-rose-600 px-3 py-1.5 rounded-lg hover:bg-rose-100 transition-colors text-xs font-medium">
                            <i class="fa-solid fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
