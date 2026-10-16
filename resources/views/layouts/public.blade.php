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

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold">
                        SN
                    </div>
                    <div>
                        <p class="text-slate-800 font-bold text-sm">SmileNova</p>
                        <p class="text-slate-500 text-xs">Dental Care</p>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ url('/') }}" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Home</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Services</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Doctors</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Blog</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-slate-700 hover:text-primary-600 rounded-lg transition">Contact</a>
                </div>
{{-- CTA --}}
<div class="flex items-center gap-2">
    @auth
        {{-- Logged in: Dashboard link + User dropdown --}}
        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex text-sm font-medium text-slate-700 hover:text-primary-600 px-3 py-2">
            Dashboard
        </a>
        <div class="relative" x-data="{ open: false }">
            <button onclick="document.getElementById('public-user-menu').classList.toggle('hidden')"
                    class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-slate-100">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white text-sm font-semibold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="hidden sm:block text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                <svg class="w-4 h-4 text-slate-500 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
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
        {{-- Not logged in: Login + Register + Book --}}
        <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-medium text-slate-700 hover:text-primary-600 px-3 py-2">
            Login
        </a>
        <a href="{{ route('register') }}" class="hidden sm:inline-flex btn btn-secondary btn-sm">
            Register
        </a>
        <a href="#" class="btn btn-primary btn-sm">
            Book Appointment
        </a>
    @endauth
</div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-16">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- Brand --}}
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold">
                            SN
                        </div>
                        <div>
                            <p class="text-white font-bold">SmileNova</p>
                            <p class="text-slate-400 text-xs">Dental Care</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md">
                        Your trusted dental care partner. Providing comprehensive dental services with modern technology and a gentle touch.
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-primary-400 transition">Services</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition">Doctors</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition">Book Appointment</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition">Contact Us</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Contact</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $clinic['clinic_address'] ?? '123 Dental Street, Mumbai' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $clinic['clinic_phone'] ?? '+91 98765 43210' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ $clinic['clinic_email'] ?? 'hello@smilenova.in' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-10 pt-6 flex flex-col sm:flex-row justify-between gap-3 text-xs text-slate-500">
                <p>© {{ date('Y') }} SmileNova Dental Care. All rights reserved.</p>
                <p>Built by Cybonetic Technologies</p>
            </div>
        </div>
    </footer>

</body>
</html>