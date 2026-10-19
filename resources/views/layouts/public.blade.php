<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SmileNova Dental Care') — Modern Dental Clinic</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">

    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold">SN</div>
                    <div>
                        <p class="text-slate-800 font-bold text-sm">SmileNova</p>
                        <p class="text-slate-500 text-xs">Dental Care</p>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Home</a>
                    <a href="{{ route('home') }}#services" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Services</a>
                    <a href="{{ route('home') }}#doctors" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Doctors</a>
                    <a href="{{ route('home') }}#testimonials" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Testimonials</a>
                    <a href="{{ route('home') }}#contact" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Contact</a>
                </div>

                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex text-sm font-medium text-slate-700 hover:text-primary-600 px-3 py-2">Dashboard</a>
                        <div class="relative">
                            <button onclick="document.getElementById('public-user-menu').classList.toggle('hidden')"
                                    class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-sm font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:block text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                            </button>
                            <div id="public-user-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-slate-200 py-1 z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-medium text-slate-700 hover:text-primary-600 px-3 py-2">Login</a>
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex btn btn-secondary btn-sm">Register</a>
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Book Appointment</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-16">
        @yield('content')
    </main>

    <footer id="contact" class="bg-slate-900 text-slate-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold">SN</div>
                        <div>
                            <p class="text-white font-bold">SmileNova</p>
                            <p class="text-slate-400 text-xs">Dental Care</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md">Your trusted dental care partner. Providing comprehensive dental services with modern technology and a gentle touch.</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}#services" class="hover:text-primary-400 transition">Services</a></li>
                        <li><a href="{{ route('home') }}#doctors" class="hover:text-primary-400 transition">Doctors</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-primary-400 transition">Book Appointment</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Contact</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li>{{ $clinic['clinic_address'] ?? '123 Dental Street, Mumbai' }}</li>
                        <li>{{ $clinic['clinic_phone'] ?? '+91 98765 43210' }}</li>
                        <li>{{ $clinic['clinic_email'] ?? 'hello@smilenova.in' }}</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-10 pt-6 text-xs text-slate-500">
                © {{ date('Y') }} SmileNova Dental Care. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>