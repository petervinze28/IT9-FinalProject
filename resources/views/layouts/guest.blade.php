<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CleanTrack Login' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|dm-sans:400,500,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="auth-body">
    <div class="auth-shell">
        <!-- <section class="auth-hero">
            <div>
                <span class="badge auth-badge">Housekeeping operations</span>
                <h1>CleanTrack</h1>
                <p class="auth-copy">
                    Sign in to coordinate rooms, assign tasks, and close the loop from one mobile-friendly workspace.
                </p>
            </div>

            <div class="auth-highlights">
                <div>
                    <strong>Fast task flow</strong>
                    <p>Create and update housekeeping work in a few taps.</p>
                </div>
                <div>
                    <strong>Mobile ready</strong>
                    <p>Designed to stay readable and usable on small screens.</p>
                </div>
                <div>
                    <strong>Live overview</strong>
                    <p>See room status, assignments, and progress at a glance.</p>
                </div>
            </div>
        </section> -->

        <div class="auth-panel">
            <div class="auth-panel-head">
                <h2>CleanTrack</h2>
                <!-- <p>Use your assigned account to continue.</p> -->
            </div>

            @if ($errors->any())
                <div class="flash-error">
                    <strong>Login failed:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
