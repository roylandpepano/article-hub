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

            <!-- Password Requirements Checklist -->
            <div id="password-requirements" class="mt-2 p-3 bg-slate-50 rounded-lg border border-slate-100 hidden">
                <p class="text-xs font-medium text-slate-600 mb-2">Password must contain:</p>
                <ul class="space-y-1">
                    <li id="req-length" class="text-xs text-slate-400 flex items-center">
                        <i class="fa-regular fa-circle mr-2 text-[10px]"></i> At least 8 characters
                    </li>
                    <li id="req-uppercase" class="text-xs text-slate-400 flex items-center">
                        <i class="fa-regular fa-circle mr-2 text-[10px]"></i> One uppercase letter
                    </li>
                    <li id="req-lowercase" class="text-xs text-slate-400 flex items-center">
                        <i class="fa-regular fa-circle mr-2 text-[10px]"></i> One lowercase letter
                    </li>
                    <li id="req-number" class="text-xs text-slate-400 flex items-center">
                        <i class="fa-regular fa-circle mr-2 text-[10px]"></i> One number
                    </li>
                    <li id="req-special" class="text-xs text-slate-400 flex items-center">
                        <i class="fa-regular fa-circle mr-2 text-[10px]"></i> One special character
                    </li>
                </ul>
            </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const requirementsBox = document.getElementById('password-requirements');

        const requirements = {
            length: { regex: /.{8,}/, element: document.getElementById('req-length') },
            uppercase: { regex: /[A-Z]/, element: document.getElementById('req-uppercase') },
            lowercase: { regex: /[a-z]/, element: document.getElementById('req-lowercase') },
            number: { regex: /[0-9]/, element: document.getElementById('req-number') },
            special: { regex: /[!@#$%^&*(),.?":{}|<>]/, element: document.getElementById('req-special') }
        };

        passwordInput.addEventListener('focus', function() {
            requirementsBox.classList.remove('hidden');
        });

        passwordInput.addEventListener('input', function() {
            const value = this.value;

            for (const key in requirements) {
                const req = requirements[key];
                const isValid = req.regex.test(value);
                const icon = req.element.querySelector('i');

                if (isValid) {
                    req.element.classList.remove('text-slate-400');
                    req.element.classList.add('text-emerald-600');
                    icon.classList.remove('fa-circle', 'fa-regular');
                    icon.classList.add('fa-check-circle', 'fa-solid');
                } else {
                    req.element.classList.add('text-slate-400');
                    req.element.classList.remove('text-emerald-600');
                    icon.classList.add('fa-circle', 'fa-regular');
                    icon.classList.remove('fa-check-circle', 'fa-solid');
                }
            }
        });
    });
</script>
@endsection
