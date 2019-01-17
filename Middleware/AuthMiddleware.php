<?php

namespace App\Auth\Middleware;

use Rudra\ExternalTraits\AuthTrait;

class AuthMiddleware
{

    use AuthTrait;

    public function __invoke()
    {
        $this->auth();
    }
}
