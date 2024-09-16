<!doctype html>
<html lang="de">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mein Lernplan - Einloggen</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body class="login-page">
  <div id="login-container" class="login-container">
    <div class="background"></div>
    <div class="container">
      <h2>Einloggen</h2>

      <!-- Fehlermeldungen anzeigen -->
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('auth.login') }}" role="form" aria-label="Login Formular">
        @csrf
        <div class="form-group">
          <label for="username">Benutzername</label>
          <input type="text" name="username" id="username" class="form-control" autocomplete="username" required aria-label="Benutzername">
        </div>
        <div class="form-group">
          <label for="password">Passwort</label>
          <input type="password" name="password" id="password" class="form-control" autocomplete="current-password" required aria-label="Passwort">
        </div>
        <div class="form-group form-check">
          <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input">
          <label for="remember_me" class="form-check-label" aria-label="Eingeloggt bleiben">Eingeloggt bleiben</label>
        </div>
        <div class="form-group">
          <button type="submit" class="btn-custom" aria-label="Einloggen">Login</button>
        </div>
      </form>
    </div>
  </div>

  <!-- JavaScript mit defer laden -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>