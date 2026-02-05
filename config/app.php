<?php

return [
    'name' => env('APP_NAME', 'E-Commerce'),

    'env' => env('APP_ENV', 'local'),

    'providers' => [
        App\Providers\RepositoryServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
    ],
];
