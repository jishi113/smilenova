<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome') — SmileNova</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="min-h-screen flex">

    {{-- LEFT PANEL — Branding (hidden on mobile) --}}
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-primary-700 via-primary-800 to-slate-900 p-12 flex-col justify-between overflow-hidden">

        {{-- Decorative circles --}}
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-white/5"></div>

        {{-- Logo --}}
        <div class="relative z-10 flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center text-white font-bold text-lg">
                SN
            </div>
            <div>
                <p class="text-white font-bold text-lg">SmileNova</p>
                <p class="text-primary-200 text-xs">Dental Care</p>
            </div>
        </div>

        {{-- Middle content --}}
        <div class="relative z-10 space-y-6">
            <h1 class="text-4xl font-bold text-white leading-tight">
                Modern Dental<br>
                Clinic Management
            </h1>
            <p class="text-primary-100 text-base">
                A complete system for managing patients, appointments, doctors, billing, and content — all in one place.
            </p>

            <ul class="space-y-3 pt-4">
                <li class="flex items-center gap-3 text-primary-100">
                    <span class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Smart appointment scheduling
                </li>
                <li class="flex items-center gap-3 text-primary-100">
                    <span class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Complete patient records & history
                </li>
                <li class="flex items-center gap-3 text-primary-100">
                    <span class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Billing with GST invoices
                </li>
                <li class="flex items-center gap-3 text-primary-100">
                    <span class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    Role-based access control
                </li>
            </ul>
        </div>

        {{-- Footer --}}
        <div class="relative z-10 text-primary-200 text-xs">
            © {{ date('Y') }} SmileNova Dental Care — Cybonetic Technologies
        </div>
    </div>

    {{-- RIGHT PANEL — Form --}}
    <div class="flex-1 flex flex-col justify-center px-6 sm:px-12 lg:px-16 py-12 bg-slate-50">
        <div class="w-full max-w-md mx-auto">

            {{-- Mobile logo --}}
            <div class="lg:hidden flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white font-bold">
                    SN
                </div>
                <div>
                    <p class="font-bold text-slate-800">SmileNova</p>
                    <p class="text-slate-500 text-xs">Dental Care</p>
                </div>
            </div>

            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>