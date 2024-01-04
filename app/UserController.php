<?php

namespace App;

use Core\Controller;

class UserController extends Controller
{
    public function index()
    {

    }

    public function show()
    {

    }

    public function before(string $action, array $params = []): bool
    {
        return parent::before($action, $params);
    }

}
