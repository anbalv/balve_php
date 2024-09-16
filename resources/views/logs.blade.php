@extends('layouts.no_header_layout')

@section('title', 'Log Übersicht')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/logging_page.css') }}">
@endsection

@section('content')
<div class="screenshot-container">
    <button id="screenshot-button">Screenshot erstellen</button>
    <div class="logging-container">
        <h1>Log Übersicht für den {{ $logDate }}</h1>

        @if($logs->count() > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-header">
                <tr>
                    <th>#</th>
                    <th>Timestamp</th>
                    <th>Level</th>
                    <th>Method</th>
                    <th>Message</th>
                    <th>User</th>
                    <th>URL</th>
                    <th>Anfrage-bezogene Infos</th>
                    <th>Job-bezogene Infos</th>
                    <th>Fehlerbezogene Infos</th>
                    <th>Datenbank-bezogene Infos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $index => $log)
                <tr class="{{ strtolower($log['level_name'] ?? 'unknown') }}-log">
                    <td>{{ $log['extra']['log_number'] ?? $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($log['extra']['timestamp'])->format('d.m.Y H:i') }} Uhr</td>
                    <td>{{ $log['level_name'] ?? 'N/A' }}</td>
                    <td>{{ $log['extra']['method'] ?? 'N/A' }}</td>

                    <!-- Wrap message in <pre> for better formatting -->
                    <td class="message-info">
                        <code>
                            {{ $log['message'] ?? 'N/A' }}
                            <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                        </code>
                    </td>

                    <td>
                        <strong>User ID:</strong><br>
                        {{ $log['extra']['user_id'] ?? 'guest' }}
                        <br><br>
                        <strong>Username:</strong><br>
                        {{ $log['extra']['username'] ?? 'guest' }}
                        <br><br>
                        <strong>Role:</strong><br>
                        {{ $log['extra']['role'] ?? 'guest' }}
                    </td>

                    <td>{{ $log['extra']['url'] ?? 'N/A' }}</td>

                    <td class="anfrage-info">
                        <!-- Request ID -->
                        <div>
                            <strong>Request ID:</strong>
                            <code>
                                {{ $log['extra']['request_id'] ?? 'no-request-id' }}
                                <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                            </code>
                        </div>
                        <br>
                        <!-- Session ID -->
                        <div>
                            <strong>Session ID:</strong>
                            <code>
                                {{ $log['extra']['session_id'] ?? 'N/A' }}
                                <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                            </code>
                        </div>
                        <br>

                        <!-- Session Data -->
                        <details class="code-details">
                            <summary>Session Data</summary>

                            <br>
                            <div>
                                <strong>_token:</strong>
                                <code>
                                    {{ $log['extra']['session_data']['_token'] ?? 'N/A' }}
                                    <span class="copy-icon" onclick="copyToClipboard(this)">📋</span>
                                </code>
                            </div>

                            <br>

                            <div>
                                <strong>URL:</strong>
                                <code>
                                    {{ $log['extra']['session_data']['_previous']['url'] ?? 'N/A' }}
                                    <span class="copy-icon" onclick="copyToClipboard(this)">📋</span>
                                </code>
                            </div>

                            <br>

                            <!-- _flash Details -->
                            <details class="code-details">
                                <summary>_flash</summary>
                                <br>
                                <div>
                                    <strong>Old Flash Data:</strong>
                                    <code>
                                        {{ json_encode($log['extra']['session_data']['_flash']['old'] ?? [], JSON_PRETTY_PRINT) }}
                                        <span class="copy-icon" onclick="copyToClipboard(this)">📋</span>
                                    </code>
                                </div>
                                <br>
                                <div>
                                    <strong>New Flash Data:</strong>
                                    <code>
                                        {{ json_encode($log['extra']['session_data']['_flash']['new'] ?? [], JSON_PRETTY_PRINT) }}
                                        <span class="copy-icon" onclick="copyToClipboard(this)">📋</span>
                                    </code>
                                </div>
                                <br>

                            </details>
                        </details>

                        <!-- Headers -->
                        <details class="code-details">
                            <summary>Headers</summary>

                            <!-- Accept & Fetch-related Headers -->
                            <details class="code-details">
                                <summary>Accept & Fetch-related Headers</summary>
                                <br>
                                @foreach(['accept-language', 'accept-encoding', 'accept', 'sec-fetch-dest', 'sec-fetch-user', 'sec-fetch-mode', 'sec-fetch-site', 'sec-ch-ua-platform', 'sec-ch-ua-mobile', 'sec-ch-ua', 'connection'] as $header)
                                <div>
                                    <strong>{{ $header }}:</strong>
                                    <code>
                                        {{ json_encode($log['extra']['headers'][$header] ?? 'N/A', JSON_PRETTY_PRINT) }}
                                        <span class="copy-icon" onclick="copyToClipboard(this)">📋</span>
                                    </code>
                                </div>
                                <br>
                                @endforeach
                            </details>

                            <!-- User-Agent & Client Info -->
                            <details class="code-details">
                                <summary>User-Agent & Client Info</summary>
                                <br>
                                @foreach(['user-agent', 'upgrade-insecure-requests'] as $header)
                                <div>
                                    <strong>{{ $header }}:</strong>
                                    <code>
                                        {{ json_encode($log['extra']['headers'][$header] ?? 'N/A', JSON_PRETTY_PRINT) }}
                                        <span class="copy-icon" onclick="copyToClipboard(this)">📋</span>
                                    </code>
                                </div>
                                <br>
                                @endforeach
                            </details>

                            <!-- Host Info -->
                            <details class="code-details">
                                <summary>Host Info</summary>
                                <br>
                                <div>
                                    <strong>host:</strong>
                                    <code>
                                        {{ json_encode($log['extra']['headers']['host'] ?? 'N/A', JSON_PRETTY_PRINT) }}
                                        <span class="copy-icon" onclick="copyToClipboard(this)">📋</span>
                                    </code>
                                </div>
                                <br>
                            </details>
                        </details>

                        <!-- Cookies -->
                        <details class="code-details">
                            <summary>Cookies</summary>
                            <br>
                            @if(isset($log['extra']['headers']['cookie'][0]))
                            @php
                            // Extrahiere den Cookie-String und splitte ihn in einzelne Cookies
                            $cookies = explode('; ', $log['extra']['headers']['cookie'][0]);
                            @endphp
                            @foreach($cookies as $cookie)
                            @php
                            // Trenne jeden Cookie in Name und Wert
                            $cookieParts = explode('=', $cookie, 2);
                            $cookieName = $cookieParts[0] ?? 'Unknown';
                            $cookieValue = $cookieParts[1] ?? 'N/A';
                            @endphp
                            <div>
                                <strong>{{ $cookieName }}:</strong>
                                <code>
                                    {{ json_encode($cookieValue, JSON_PRETTY_PRINT) }}
                                    <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                                </code>
                            </div>
                            <br>
                            @endforeach
                            @else
                            <p>Keine Cookies vorhanden.</p>
                            @endif
                        </details>
                    </td>

                    <!-- Job-bezogene Infos -->
                    <td>
                        <strong>Job Name:</strong>
                        <br>
                        {{ $log['extra']['job_name'] ?? 'N/A' }}
                        <br><br>
                        <strong>Queue Name:</strong>
                        <br>
                        {{ $log['extra']['queue_name'] ?? 'N/A' }}
                    </td>

                    <!-- Fehlerbezogene Infos -->
                    <td>
                        <details class="code-details">
                            <summary>Exception Message</summary>
                            <code>
                                {{ $log['extra']['exception_message'] ?? 'N/A' }}
                                <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                            </code>
                        </details>
                        <br>

                        <details class="code-details">
                            <summary>Exception Trace</summary>
                            <code>
                                {{ $log['extra']['exception_trace'] ?? 'N/A' }}
                                <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                            </code>
                        </details>
                        <br>

                        <details class="code-details">
                            <summary>Exception Code</summary>
                            <code>
                                {{ $log['extra']['exception_code'] ?? 'N/A' }}
                                <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                            </code>
                        </details>
                    </td>

                    <!-- Datenbank-bezogene Infos -->
                    <td>
                        <details class="code-details">
                            <summary>Queries</summary>
                            <div>
                                <strong>Query:</strong>
                                <code>
                                    {{ json_encode($log['extra']['queries']['query'] ?? 'No query', JSON_PRETTY_PRINT) }}
                                    <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                                </code>
                            </div>
                            <br>
                            <div>
                                <strong>Bindings:</strong>
                                <code>
                                    {{ json_encode($log['extra']['queries']['bindings'] ?? 'No bindings', JSON_PRETTY_PRINT) }}
                                    <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                                </code>
                            </div>
                            <br>
                            <div>
                                <strong>Time (ms):</strong>
                                <code>
                                    {{ $log['extra']['queries']['time'] ?? 'No time' }}
                                    <span class="copy-icon" title="Copy" onclick="copyToClipboard(this)">📋</span>
                                </code>
                            </div>
                        </details>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination-Kontrollen -->
        <div class="pagination-container">
            {{ $logs->links() }}
        </div>
        @else
        <p>Keine Logs für den aktuellen Tag gefunden.</p>
        @endif
    </div>
</div>
@endsection

@section('additional_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="{{ asset('js/logging_page.js') }}" defer></script>
<script>
    function copyToClipboard(element) {
        var codeBlock = element.closest("code, pre");

        if (!codeBlock) {
            console.error("Kein gültiges Code-Element gefunden.");
            return;
        }

        var textToCopy = codeBlock.textContent.replace("📋", "").trim();

        navigator.clipboard
            .writeText(textToCopy)
            .then(function() {
                element.innerHTML = "✔️";
                element.classList.add('copied');

                setTimeout(function() {
                    element.innerHTML = "📋";
                    element.classList.remove('copied');
                }, 1000);
            })
            .catch(function(error) {
                console.error('Fehler beim Kopieren: ', error);
            });
    }
</script>
@endsection