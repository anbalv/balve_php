<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Mein Lernplan')</title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    @yield('additional_css')

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body data-user-id="{{ Auth::check() ? Auth::id() : '0' }}">
    @if($show_menu ?? false)
    <header class="header flex-container">
        <div class="logo-container">
            @auth
            <script>
                console.log("User is authenticated. Role: {{ Auth::user()->role }}");
            </script>
            @else
            <script>
                console.log("User is NOT authenticated.");
            </script>
            @endauth

            <a href="{{ Auth::check() && Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="logo">
                <span class="logo-part">Mein</span>
                <span class="logo-part">Lernplaner</span>
            </a>
        </div>

        <!-- Desktop-Navigation -->
        @include('partials.navigation', ['class' => 'nav-container'])

        <div class="header-right">
            @if(Auth::check() && in_array(Auth::user()->role, ['user1', 'user2']))
            <div class="score-container">
                <div id="current-month-year"></div>
                <div class="progress-container">
                    <div class="progress-bar" id="progress-bar"></div>
                </div>
                <div id="stars-container" class="stars-container"></div>
            </div>
            @endif
        </div>

        <div class="clock-container">
            <span id="clock" class="clock"></span>
        </div>

        <!-- Hamburger Menu Icon -->
        <div class="hamburger-menu" id="hamburger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Sidebar Navigation Menu -->
        @include('partials.navigation', ['class' => 'sidebar-menu'])
    </header>
    @endif

    <main class="main-container p-4 w-screen max-h-screen">
        @yield('content')
    </main>

    <div id="snackbar-container"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.socket.io/4.6.1/socket.io.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('additional_js')
</body>

</html>