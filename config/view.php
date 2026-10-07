<?php
//condiguracion de las vistas, donde se encuentran las vistas y donde se compilan
return [
    'paths' => [
        resource_path('views'),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),
];
