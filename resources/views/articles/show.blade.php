@extends('layout.app')

@section('content')
<div class="bg-white p-8 rounded shadow">
    <div class="mb-6">
        <h1 class="text-4xl font-bold mb-2">{{ $article->title }}</h1>
        <div class="text-gray-600 flex items-center gap-2">
            <span>By {{ $article->author->name }}</span>
            <span>&bull;</span>
            <span>{{ $article->created_at->format('F d, Y') }}</span>
            @if($article->categories->count() > 0)
                <span>&bull;</span>
                <div class="flex gap-2">
                    @foreach($article->categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs hover:bg-gray-300">{{ $category->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="prose max-w-none mb-8">
        {!! nl2br(e($article->content)) !!}
    </div>

    <div class="flex items-center justify-between border-t pt-6">
        <a href="{{ route('articles.index') }}" class="text-blue-600 hover:underline">&larr; Back to Articles</a>

        @auth
            @if(auth()->id() === $article->author_id)
                <div class="flex gap-4">
                    <a href="{{ route('articles.edit', $article) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
