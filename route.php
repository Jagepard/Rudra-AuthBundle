<?php

namespace App\Auth;

use Rudra\Router;

class Route
{

    /**
     * $this->route('auth', 'common');
     * и $this->collect($this->withOut(['auth']), $this->container()->config('database', 'active'));
     * при использовании collect в общем рутинге
     *
     * @param Router $router
     * @param        $namespace
     * @param        $params
     */
    public function run(Router $router, $namespace, $params)
    {
        $router->setNamespace($namespace);
        $router->annotationCollector($params);
    }
}
