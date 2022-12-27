<?php

return [
    'migration_dirs' => [
        'first' => './database/migrations'
    ],
    'environments' => [
        'development' => [
            'adapter' => 'mysql',
            'host' => 'database',
            'port' => 3306,
            'username' => 'root',
            'password' => '0nb04rd1ng',
            'db_name' => 'onboarding',
            'charset' => 'utf8mb4'
        ],
        'test' => [
            'adapter' => 'mysql',
            'host' => 'database',
            'port' => 3306,
            'username' => 'root',
            'password' => '0nb04rd1ng',
            'db_name' => 'onboarding_test',
            'charset' => 'utf8mb4'
        ]
    ],
    'default_environment' => 'development',
    'log_table_name' => 'phoenix_log'
];