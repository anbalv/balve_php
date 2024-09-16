<?php

return [
    'mail' => [
        'mail_host' => env('MAIL_HOST', 'w01bf0c4.kasserver.com'),
        'mail_port' => env('MAIL_PORT', 465),
        'mail_username' => env('MAIL_USERNAME', 'm06cd637'),
        'mail_password' => env('MAIL_PASSWORD', 'YRNM2TmKmVpR7rNgkBLW'),
        'mail_encryption' => env('MAIL_ENCRYPTION', 'ssl'),
    ],
    'session' => [
        'cookie_secure' => env('SESSION_COOKIE_SECURE', true),
        'session_lifetime' => env('SESSION_LIFETIME', 120),
    ],
    'leonie' => [
        'imap_server' => env('LEONIE_IMAP_SERVER', 'w01bf0c4.kasserver.com'),
        'imap_port' => env('LEONIE_IMAP_PORT', 993),
        'email_account' => env('LEONIE_EMAIL_ACCOUNT', 'leonie@fa-balve.com'),
        'email_password' => env('LEONIE_EMAIL_PASSWORD', 'YeBScN6PCmpfMctYrn72'),
    ],
    'isabelle' => [
        'imap_server' => env('ISABELLE_IMAP_SERVER', 'w01bf0c4.kasserver.com'),
        'imap_port' => env('ISABELLE_IMAP_PORT', 993),
        'email_account' => env('ISABELLE_EMAIL_ACCOUNT', 'isabelle@fa-balve.com'),
        'email_password' => env('ISABELLE_EMAIL_PASSWORD', 'A9Wog9cz96dt4CnMfwnh'),
    ],
];
