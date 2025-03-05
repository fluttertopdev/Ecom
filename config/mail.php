<?php
return [
    'default' => env('MAIL_MAILER', 'smtp'),

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.googlemail.com'),
            'port' => env('MAIL_PORT', 465),
            'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'your_email@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Your Application'),
    ],
];


