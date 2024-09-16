@extends('layouts.app')

@section('content')
<div class="container-register">
    <h2>Registrieren</h2>
    <form method="POST" action="">
        @csrf
        <div class="form-group">
            <label for="username">Benutzername</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="role">Rolle</label>
            <select name="role" id="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="user1">Leonie Balve</option>
                <option value="user2">Isabelle Balve</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Passwort</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Passwort bestätigen</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrieren</button>
    </form>
</div>
@endsection