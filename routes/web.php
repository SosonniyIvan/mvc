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

Router::add(
    'posts/{post_id:\d+}/comment/{comment_id:\d+}',
    [
        'controller' => \App\Controllers\UsersController::class,
        'action' =>'show',
        'method' => 'GET'
    ]
);
