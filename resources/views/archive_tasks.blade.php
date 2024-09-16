@extends('layouts.app')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
@endsection

@section('content')
<div class="archive-container">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="archive-innen-container">
        <h1 class="archive-text-4xl mb-4">Aufgaben Archivieren</h1>
        <p class="archive-note">*Nur wiederkehrende Aufgaben werden archiviert.</p>
        <div class="archive-content">
            <form action="{{ route('admin.archive_tasks') }}" method="POST">
                @csrf
                <div>
                    <label for="start_date">Startdatum:</label>
                    <input type="date" id="start_date" name="start_date" required />
                </div>
                <div>
                    <label for="end_date">Enddatum:</label>
                    <input type="date" id="end_date" name="end_date" required />
                </div>
                <div class="button-container">
                    <button type="submit" class="btn-archive">Archivieren</button>
                </div>
            </form>
        </div>
        <div>
            <h2>Archivierte Aufgaben und Punkte pro Benutzer</h2>
            <table class="archive-table">
                <thead>
                    <tr>
                        <th>Benutzer</th>
                        <th>Anzahl archivierter Aufgaben</th>
                        <th class="tooltip">
                            Zugewiesene Punkte
                            <span class="tooltiptext">Gesamtpunktzahl, die erreicht werden konnte.</span>
                        </th>
                        <th class="tooltip">
                            Verdiente Punkte
                            <span class="tooltiptext">Tatsächlich erreichte Punktzahl.</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user_points as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->archived_count }}</td>
                        <td>{{ $user->total_assigned_points }}</td>
                        <td class="@if(!$user->total_earned_points) none-value @endif">
                            {{ $user->total_earned_points ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Keine archivierten Aufgaben gefunden.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection