@extends('layout.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Register</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" name="password" id="password" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" required>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Register</button>
    </form>
</div>
@endsection
