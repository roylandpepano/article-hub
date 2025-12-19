<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-600 text-sm font-sans antialiased selection:bg-indigo-100 selection:text-indigo-700">
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 mb-8 sticky top-0 z-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="flex justify-between items-center py-3">
                <div class="flex flex-row items-center gap-1">
                    <img src="{{ asset('article-hub.png') }}" alt="Article Hub Logo" class="h-12 w-12">
                    <a href="/" class="text-lg font-bold text-slate-800 tracking-tight hover:text-indigo-600 transition-colors">Article Hub</a>
                </div>
                <div class="flex items-center gap-4 text-xs font-medium">
                    @auth
                        <span class="text-slate-500 hidden sm:inline">Hi, {{ auth()->user()->name }}!</span>
                        <a href="{{ route('articles.my_articles') }}" class="text-slate-600 hover:text-indigo-600 transition-colors">
                            <i class="fa-solid fa-layer-group mr-1"></i> My Articles
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-rose-400 hover:text-rose-600 transition-colors">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 transition-colors">
                            <i class="fa-solid fa-right-to-bracket mr-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-full hover:bg-indigo-200 transition-colors">
                            <i class="fa-solid fa-user-plus mr-1"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 max-w-4xl">
        @yield('content')
        <footer class="mt-8 text-center text-xs text-slate-400 mb-3">© 2025 Article Hub. All rights reserved.</footer>
    </main>

    <script type="module">
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                iziToast.success({
                    title: 'Success',
                    message: "{{ session('success') }}",
                    position: 'topCenter'
                });
            @endif

            @if(session('error'))
                iziToast.error({
                    title: 'Error',
                    message: "{{ session('error') }}",
                    position: 'topCenter'
                });
            @endif

            @if(session('info'))
                iziToast.info({
                    title: 'Info',
                    message: "{{ session('info') }}",
                    position: 'topCenter'
                });
            @endif

            @if(session('warning'))
                iziToast.warning({
                    title: 'Warning',
                    message: "{{ session('warning') }}",
                    position: 'topCenter'
                });
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    iziToast.error({
                        title: 'Error',
                        message: "{{ $error }}",
                        position: 'topCenter'
                    });
                @endforeach
            @endif
        });
    </script>
</body>
</html>
