@extends('layouts.app')

@section('title', 'Temporäres Passwort ändern')

@section('content')
<div class="change-password-container">
    <h1>Passwort ändern</h1>

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

    <!-- Erfolgsmeldung anzeigen -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('auth.change_password') }}">
        @csrf <!-- This is important for security -->
        <div class="form-group">
            <label for="new_password">Neues Passwort</label><br />
            <input type="password" name="new_password" class="form-control" id="new_password" size="32" required autocomplete="new-password" aria-label="Neues Passwort">
        </div>
        <div class="form-group">
            <label for="confirm_password">Passwort bestätigen</label><br />
            <input type="password" name="new_password_confirmation" class="form-control" id="confirm_password" size="32" required autocomplete="new-password" aria-label="Passwort bestätigen">
        </div>
        <div class="form-group">
            <button type="submit" class="btn-password">Passwort ändern</button>
        </div>
    </form>
</div>
@endsection