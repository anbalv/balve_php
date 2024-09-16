<!doctype html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Willkommen - Mein Lernplan</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Lernplattform für deine persönliche Weiterentwicklung. Sei klug, sei mutig, sei du!">
    <meta name="keywords" content="Lernen, Bildung, Erfolg, Lernplattform">
    <meta name="author" content="Dein Name oder Firma">

    <!-- Open Graph Tags für soziale Medien -->
    <meta property="og:title" content="Willkommen - Mein Lernplan">
    <meta property="og:description" content="Deine Zukunft beginnt hier und jetzt. Lernen ist der Schlüssel zum Erfolg.">
    <meta property="og:image" content="{{ asset('images/social-share.jpg') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    <main class="main-container container mx-auto p-4">
        <div id="background"></div>
        <div class="center-container">
            <a href="{{ route('auth.login') }}" class="welcome-button" aria-label="Zum Login">Zum Login</a>
        </div>
        <div class="slogan-container">
            <span class="slogan slogan1">Sei klug, sei mutig, sei du!</span>
            <span class="slogan slogan2">Sei die Heldin deiner eigenen Geschichte!</span>
            <span class="slogan slogan3">Deine Zukunft beginnt hier und jetzt.</span>
            <span class="slogan slogan4">Lernen ist der Schlüssel zum Erfolg.</span>
            <span class="slogan slogan5">Mit Lernen kommst du überall hin – sogar bis zum Mond!</span>
            <span class="slogan slogan6">Lernst du heute, bist du morgen der Boss!</span>
        </div>
    </main>
</body>

</html>