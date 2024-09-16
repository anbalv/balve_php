@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-container">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <!-- Meta-Tags zur Übergabe der Laravel-Routen an JavaScript -->
    <meta name="set-temp-password-route" content="{{ route('set_temp_password', '') }}">
    <meta name="change-role-route" content="{{ route('change_role') }}">

    <div class="admin-content">
        <div class="admin-inner-content">
            <h1 class="admin-text-4xl mb-4">Benutzerinformationen</h1>
            <div class="overflow-x-auto">
                <div class="table-wrapper">
                    <table class="admin-table min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border">ID</th>
                                <th class="py-2 px-4 border">Username</th>
                                <th class="py-2 px-4 border">Temporäres Passwort</th>
                                <th class="py-2 px-4 border">Temporäres Passwort generieren</th>
                                <th class="py-2 px-4 border">Aktuelle Rolle</th>
                                <th class="py-2 px-4 border">Rolle ändern</th>
                                <th class="py-2 px-4 border">E-Mail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="py-2 px-4 border">{{ $user->id }}</td>
                                <td class="py-2 px-4 border">{{ $user->username }}</td>
                                <td class="py-2 px-4 border temp-password" data-user-id="{{ $user->id }}">
                                    @if($user->temp_password)
                                    {{ $user->temp_password }}
                                    @else
                                    <span class="centered">-</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border temp-password-action">
                                    <form method="POST" action="{{ route('set_temp_password', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary generate-temp-password-btn" data-user-id="{{ $user->id }}">Temporäres Passwort generieren</button>
                                    </form>
                                </td>
                                <td class="py-2 px-4 border current-role">{{ $user->role }}</td>
                                <td class="py-2 px-4 border">
                                    <select class="role-dropdown" data-user-id="{{ $user->id }}" title="Benutzerrolle auswählen">
                                        <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                                        <option value="user1" @if($user->role == 'user1') selected @endif>Leonie Balve</option>
                                        <option value="user2" @if($user->role == 'user2') selected @endif>Isabelle Balve</option>
                                    </select>
                                </td>
                                <td class="py-2 px-4 border">{{ $user->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="snackbar-container"></div>
        </div>
    </div>
</div>
@endsection