<?php

namespace App\Auth;

use Rudra\Controller;
use App\Web\Supports\TwigFunctions;
use Rudra\Interfaces\ContainerInterface;

class AuthController extends Controller
{
    use TwigFunctions;

    public function init(ContainerInterface $container, array $config)
    {
        parent::init($container, $container->config('template', 'auth'));
    }
}
