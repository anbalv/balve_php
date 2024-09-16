<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
  <title>@yield('title') - Mein Lernplan</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- jQuery mit defer laden -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

  @yield('additional_css') <!-- Hier wird das zusätzliche CSS eingefügt -->
</head>

<body class="bg-gray-100 text-gray-900 has-background" style="min-height: 100vh; overflow-y: auto;">
  @yield('content')

  @yield('additional_js') <!-- Hier wird das zusätzliche JavaScript eingefügt -->
</body>

</html>