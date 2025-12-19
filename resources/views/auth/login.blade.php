@extends('layout.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Login</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" name="password" id="password" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Login</button>
    </form>
</div>
@endsection
