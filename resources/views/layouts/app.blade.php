<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CleanTrack' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|dm-sans:400,500,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
<div class="page-shell">
    <aside class="side-panel">
        <div>
            <h1 class="brand-title">CleanTrack</h1>
            <p class="brand-subtitle">Track rooms, assign staff, and close tasks faster.</p>
        </div>

        <nav class="main-nav">
            @if (auth()->user()?->isAdmin())
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">Rooms</a>
                <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">Cleaning Tasks</a>
                <a href="{{ route('housekeepers.index') }}" class="{{ request()->routeIs('housekeepers.*') ? 'active' : '' }}">Housekeepers</a>
            @else
                <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">Rooms</a>
            @endif
        </nav>

        <div class="side-footer">
            @auth
                <div class="user-chip">
                    <span>{{ auth()->user()->name }}</span>
                    <small>{{ ucfirst(auth()->user()->role ?? 'Staff') }}</small>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            @endauth
            <p>{{ now()->format('l, F j, Y') }}</p>
            <p>{{ now()->format('h:i A') }}</p>
        </div>
    </aside>

    <main class="content-panel">
        @if (session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="flash-error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="flash-error">
                <strong>Please review the form:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
