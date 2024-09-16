<nav class="{{ $class ?? '' }}">
    @if(Auth::check() && Auth::user()->role == 'admin')
    <div class="dropdown">
        <a href="#" class="dropdown-toggle">Dashboard</a>
        <div class="dropdown-menu hidden">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                <li><a href="{{ route('admin.archive_tasks') }}">Aufgaben archivieren</a></li>
            </ul>
        </div>
    </div>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle">Aufgaben</a>
        <div class="dropdown-menu hidden">
            <ul>
                <li><a href="{{ route('tasks.overview') }}">Übersicht Aufgaben</a></li>
                <li><a href="{{ route('tasks.approval') }}">Aufgaben prüfen</a></li>
                <li><a href="{{ route('tasks.create') }}">Übungsaufgaben erstellen</a></li>
                <li><a href="{{ route('tasks.create_private') }}">Private Aufgabe / Organizer</a></li>
            </ul>
        </div>
    </div>
    <a href="{{ route('events.add') }}">Kalender</a>
    <a href="{{ route('rewards.manage') }}">Belohnungen verwalten</a>
    <a href="{{ route('auth.register') }}">Benutzer hinzufügen</a>
    @endif

    @if(Auth::check() && in_array(Auth::user()->role, ['user1', 'user2']))
    <a href="{{ route('user.dashboard') }}">Dein Dashboard</a>
    <a href="{{ route('points.calendar') }}">Punktegesamt</a>
    <a href="{{ route('rewards.page') }}" target="_blank">Belohnungswelt</a>
    <a href="{{ route('emails.page') }}" target="_blank">Emails</a>
    @endif

    @if(Auth::check())
    <a href="{{ route('auth.logout') }}">Logout</a>
    @else
    <a href="{{ route('auth.login') }}">Login</a>
    @endif
</nav>