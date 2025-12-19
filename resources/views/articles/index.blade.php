@extends('layout.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Articles</h1>
        @auth
            <a href="{{ route('articles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create New Article</a>
        @endauth
    </div>

    <div class="grid gap-6">
        @foreach($articles as $article)
            <div class="border-b pb-4 last:border-b-0">
                <h2 class="text-2xl font-semibold mb-2">{{ $article->title }}</h2>
                <p class="text-gray-600 mb-2">By {{ $article->author->name }} on {{ $article->created_at->format('M d, Y') }}</p>
                <p class="text-gray-800 mb-4">{{ Str::limit($article->content, 150) }}</p>

                <div class="flex items-center gap-4">
                    {{-- <a href="{{ route('articles.show', $article) }}" class="text-blue-600 hover:underline">Read more</a> --}}

                    @auth
                        @if(auth()->id() === $article->author_id)
                            <a href="{{ route('articles.edit', $article) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach

        @if($articles->isEmpty())
            <p class="text-gray-500">No articles found.</p>
        @endif
    </div>
</div>
@endsection
