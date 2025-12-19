@extends('layout.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Create Article</h2>

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" name="title" id="title" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="content" class="block text-gray-700 font-bold mb-2">Content</label>
            <textarea name="content" id="content" rows="10" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required>{{ old('content') }}</textarea>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('articles.index') }}" class="text-gray-600 mr-4 py-2">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Create Article</button>
        </div>
    </form>
</div>
@endsection
