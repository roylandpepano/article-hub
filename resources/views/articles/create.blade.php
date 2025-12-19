@extends('layout.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <h2 class="text-xl font-bold text-slate-800 mb-6 tracking-tight">Create Article</h2>

    <form action="{{ route('articles.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="title" class="block text-xs font-medium text-slate-700 mb-1">Title</label>
            <input type="text" name="title" id="title" class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors" value="{{ old('title') }}" required placeholder="Enter article title">
            @error('title')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category_ids" class="block text-xs font-medium text-slate-700 mb-1">Categories</label>
            <select name="category_ids[]" id="category_ids" multiple class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors h-32">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', [])) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-slate-400 text-[10px] mt-1">Hold Ctrl (Windows) or Command (Mac) to select multiple categories.</p>
            @error('category_ids')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-xs font-medium text-slate-700 mb-1">Status</label>
            <select name="status" id="status" class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors">
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="content" class="block text-xs font-medium text-slate-700 mb-1">Content</label>
            <textarea name="content" id="content" rows="10" class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors placeholder:text-slate-400" required placeholder="Write your article content here...">{{ old('content') }}</textarea>
            @error('content')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end items-center gap-3 pt-4">
            <a href="{{ route('articles.index') }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 transition-colors">
                <i class="fa-solid fa-xmark mr-1"></i> Cancel
            </a>
            <button type="submit" class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-100 transition-colors text-xs font-medium">
                <i class="fa-solid fa-check mr-1"></i> Create Article
            </button>
        </div>
    </form>
</div>
@endsection
