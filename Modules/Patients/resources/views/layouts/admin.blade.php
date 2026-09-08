<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SmileNova Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: system-ui, sans-serif; background: #f4f6f8; margin:0; }
        .navbar { background:#1e293b; color:#fff; padding:1rem 1.5rem; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { color:#fff; text-decoration:none; margin-left:1rem; }
        .container { max-width:1200px; margin:2rem auto; padding:0 1rem; }
        .card { background:#fff; border-radius:8px; padding:1.25rem; box-shadow:0 1px 3px rgba(0,0,0,.1); margin-bottom:1rem; }
        table { width:100%; border-collapse:collapse; }
        th, td { text-align:left; padding:.6rem; border-bottom:1px solid #eee; }
        .btn { display:inline-block; padding:.5rem 1rem; border-radius:6px; background:#2563eb; color:#fff; text-decoration:none; border:none; cursor:pointer; }
        .btn-sm { padding:.3rem .7rem; font-size:.85rem; }
        input, select, textarea { padding:.5rem; border:1px solid #ccc; border-radius:6px; width:100%; box-sizing:border-box; }
        label { font-weight:600; font-size:.85rem; display:block; margin:.6rem 0 .2rem; }
        .badge { padding:.2rem .6rem; border-radius:12px; font-size:.75rem; background:#e2e8f0; }
        .success { background:#dcfce7; color:#166534; padding:.75rem; border-radius:6px; margin-bottom:1rem; }
        .avatar-circle { width:60px; height:60px; border-radius:50%; background:#2563eb; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:bold; margin:0 auto; }
        .grid { display:grid; gap:1rem; }
        .grid-cols-1 { grid-template-columns: 1fr; }
        @media(min-width:1024px){ .lg\:grid-cols-3 { grid-template-columns: 1fr 2fr; } }
    </style>
</head>
<body>
    <div class="navbar">
        <div><strong>SmileNova Admin</strong></div>
        <div>
            @auth
                <span>{{ auth()->user()->name }}</span>
                <a href="{{ route('patients.index') }}">Patients</a>
                <a href="{{ route('doctors.index') }}">Doctors</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-sm" style="background:#dc2626;">Logout</button>
                </form>
            @endauth
        </div>
    </div>
    <div class="container">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>