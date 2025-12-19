@extends('layout.app')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Articles</h1>

        <div class="flex flex-wrap gap-2 items-center w-full sm:w-auto">
            <form action="{{ route('articles.search') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                <select name="category" onchange="this.form.submit()" class="text-xs border-none bg-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-100 shadow-sm text-slate-600 cursor-pointer">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}" class="text-xs border-none bg-white rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-100 shadow-sm text-slate-600 w-full sm:w-48 placeholder:text-slate-400">
                <button type="submit" class="bg-indigo-50 text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-100 transition-colors text-xs font-medium">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Search
                </button>
            </form>

            @auth
                <a href="{{ route('articles.create') }}" class="bg-slate-800 text-white px-3 py-2 rounded-lg hover:bg-slate-700 transition-colors text-xs font-medium shadow-sm">
                    <i class="fa-solid fa-plus mr-1"></i> New Article
                </a>
            @endauth
        </div>
    </div>

    <div class="grid gap-4">
        @foreach($articles as $article)
            <article class="bg-white p-5 rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start mb-2">
                    <h2 class="text-lg font-semibold text-slate-800 leading-tight">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-indigo-600 transition-colors">{{ $article->title }}</a>
                    </h2>
                    @if($article->categories->count() > 0)
                        <div class="flex gap-1 flex-wrap justify-end ml-4">
                            @foreach($article->categories as $category)
                                <a href="{{ route('categories.show', $category) }}" class="bg-emerald-50 text-emerald-600 px-2 py-1 rounded-md text-[10px] font-medium hover:bg-emerald-100 transition-colors uppercase tracking-wider">
                                    <i class="fa-solid fa-tag mr-1"></i> {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="text-xs text-slate-400 mb-3 flex items-center gap-2">
                    <span>{{ $article->author->name }}</span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span>{{ $article->created_at->format('M d, Y') }}</span>
                </div>

                <p class="text-slate-600 mb-4 text-sm leading-relaxed line-clamp-2">{{ Str::limit($article->content, 150) }}</p>

                <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                    <a href="{{ route('articles.show', $article) }}" class="text-xs font-medium text-indigo-500 hover:text-indigo-600 transition-colors flex items-center gap-1">
                        Read article <span>&rarr;</span>
                    </a>

                    @auth
                        @if(auth()->id() === $article->author_id)
                            <div class="flex gap-3 text-xs">
                                <a href="{{ route('articles.edit', $article) }}" class="text-slate-400 hover:text-amber-500 transition-colors">Edit</a>
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-slate-400 hover:text-rose-500 transition-colors" onclick="confirmDelete(this.closest('form'))">Delete</button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </article>
        @endforeach

        @if($articles->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl border border-slate-100 border-dashed">
                <p class="text-slate-400 text-sm">No articles found.</p>
            </div>
        @endif
    </div>

    <div class="mt-8">
        {{ $articles->links() }}
    </div>
</div>

<script>
    function confirmDelete(form) {
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: 'Confirm Delete',
            message: 'Are you sure you want to delete this article?',
            position: 'center',
            buttons: [
                ['<button><b>Yes</b></button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    form.submit();
                }, true],
                ['<button>No</button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }],
            ],
        });
    }
</script>
@endsection
