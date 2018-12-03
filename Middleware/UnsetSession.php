<?php

namespace App\Auth\Middleware;

use App\Auth\AuthMiddleware;

class UnsetSession extends AuthMiddleware
{
    public function __invoke()
    {
        $this->container()->unsetSession('value');
        $this->container()->unsetSession('alert');
    }
}
