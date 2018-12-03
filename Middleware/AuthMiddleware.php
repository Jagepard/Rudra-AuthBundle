<?php

namespace App\Auth\Middleware;

use App\Web\WebMiddleware;
use Rudra\ExternalTraits\AuthTrait;

class AuthMiddleware extends WebMiddleware
{

    use AuthTrait;

    public function __invoke()
    {
        $this->auth();
    }
}
