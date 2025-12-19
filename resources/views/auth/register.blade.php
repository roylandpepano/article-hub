@extends('layout.app')

@section('content')
<div class="max-w-sm mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-100 mt-10">
    <h2 class="text-xl font-bold text-slate-800 mb-6 tracking-tight text-center">Create Account</h2>

    <form action="{{ route('register') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-xs font-medium text-slate-700 mb-1">Name</label>
            <input type="text" name="name" id="name" class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors" value="{{ old('name') }}" required placeholder="John Doe">
            @error('name')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" id="email" class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors" value="{{ old('email') }}" required placeholder="you@example.com">
            @error('email')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-medium text-slate-700 mb-1">Password</label>
            <input type="password" name="password" id="password" class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors" required placeholder="••••••••">
            @error('password')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-medium text-slate-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300 transition-colors" required placeholder="••••••••">
        </div>

        <button type="submit" class="w-full bg-indigo-50 text-indigo-600 font-medium py-2 px-4 rounded-lg hover:bg-indigo-100 transition-colors text-xs">
            <i class="fa-solid fa-user-plus mr-1"></i> Register
        </button>
    </form>
</div>
@endsection
