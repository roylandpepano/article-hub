<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Hub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow mb-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="/" class="text-xl font-bold text-gray-800">Article Hub</a>
                <div>
                    @auth
                        <span class="text-gray-600 mr-4">Welcome, {{ auth()->user()->name }}</span>
                        <a href="{{ route('articles.my_articles') }}" class="text-gray-600 hover:text-gray-800 mr-4">My Articles</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 mr-4">Login</a>
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4">
        @yield('content')
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
