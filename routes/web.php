<?php

use App\UserController;
use Core\Router;

Router::add(
    'users/{id:\d+}/edit',
    [
        'controller' => UserController::class,
        'action' => 'edit',
        'method' => 'GET'
    ]
);
