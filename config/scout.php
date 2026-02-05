<?php

return [
    'driver' => env('SCOUT_DRIVER', 'elastic'),
    'elasticsearch' => [
        'index' => env('ELASTICSEARCH_INDEX', 'products'),
        'hosts' => [env('ELASTICSEARCH_HOST', 'http://elasticsearch:9200')],
    ],
];
