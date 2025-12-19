@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Category: {{ $category->name }}</h1>
        <a href="{{ route('articles.index') }}" class="text-blue-500 hover:underline">Back to Articles</a>
    </div>

    @if($articles->count() > 0)
        <div class="space-y-6">
            @foreach($articles as $article)
                <div class="border-b pb-4 last:border-b-0 last:pb-0">
                    <h2 class="text-2xl font-semibold mb-2">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600">
                            {{ $article->title }}
                        </a>
                    </h2>
                    <div class="text-gray-600 text-sm mb-2">
                        By {{ $article->author->name }} | {{ $article->created_at->format('M d, Y') }}
                    </div>
                    <p class="text-gray-700 mb-4">
                        {{ Str::limit($article->content, 150) }}
                    </p>
                    <a href="{{ route('articles.show', $article) }}" class="text-blue-500 hover:underline">Read more</a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No articles found in this category.</p>
    @endif
</div>
@endsection
