<x-guest-layout>

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Welcome back</h2>
        <p class="text-slate-500 text-sm mt-1">Sign in to your SmileNova account</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   autocomplete="username"
                   class="form-input"
                   placeholder="you@smilenova.in">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   class="form-input"
                   placeholder="••••••••">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me"
                       type="checkbox"
                       name="remember"
                       class="rounded border-slate-300 text-primary-600 shadow-sm focus:ring-primary-500">
                <span class="text-sm text-slate-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full justify-center py-2.5">
            Sign In
        </button>

        {{-- Register link --}}
        @if (Route::has('register'))
            <p class="text-center text-sm text-slate-600 pt-2">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Create one
                </a>
            </p>
        @endif

    </form>

  

</x-guest-layout>