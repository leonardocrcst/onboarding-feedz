<?php

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],

        'db' => [
            'driver' => 'mysql',
            'host' => 'database',
            'port' => 3306,
            'database' => 'onboarding',
            'username' => 'root',
            'password' => '0nb04rd1ng',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ],

        'db_test' => [
            'driver' => 'mysql',
            'host' => 'database',
            'port' => 3306,
            'database' => 'onboarding_test',
            'username' => 'root',
            'password' => '0nb04rd1ng',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]
    ],
];
