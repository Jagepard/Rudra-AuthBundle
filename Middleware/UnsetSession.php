<?php

namespace App\Auth\Middleware;

class UnsetSession
{
    public function __invoke()
    {
        rudra()->unsetSession('value');
        rudra()->unsetSession('alert');
    }
}
