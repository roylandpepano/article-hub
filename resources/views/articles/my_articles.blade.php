@extends('layout.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">My Articles</h1>
        <a href="{{ route('articles.create') }}" class="bg-slate-800 text-white px-3 py-2 rounded-lg hover:bg-slate-700 transition-colors text-xs font-medium shadow-sm">
            <i class="fa-solid fa-plus mr-1"></i> New Article
        </a>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100">
        <form action="{{ route('articles.my_articles') }}" method="GET" class="flex flex-wrap gap-3 mb-6">
            <select name="category" onchange="this.form.submit()" class="text-xs border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors text-slate-600 cursor-pointer">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="text-xs border-slate-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors text-slate-600 cursor-pointer">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="py-3 px-4 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Title</th>
                        <th class="py-3 px-4 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Created At</th>
                        <th class="py-3 px-4 text-left text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-right text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($articles as $article)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="py-3 px-4">
                                <a href="{{ route('articles.show', $article) }}" class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">{{ $article->title }}</a>
                            </td>
                            <td class="py-3 px-4 text-xs text-slate-500">{{ $article->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 inline-flex text-[10px] font-medium rounded-full {{ $article->status === 'published' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-3 text-xs">
                                    <a href="{{ route('articles.edit', $article) }}" class="text-slate-400 hover:text-amber-500 transition-colors">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-slate-400 hover:text-rose-500 transition-colors" onclick="confirmDelete(this.closest('form'))">
                                            <i class="fa-solid fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($articles->isEmpty())
                <div class="text-center py-12">
                    <p class="text-slate-400 text-sm">You haven't posted any articles yet.</p>
                </div>
            @endif

            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>
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
