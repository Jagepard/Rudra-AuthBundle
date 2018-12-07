<?php

namespace App\Auth\Controllers;

use App\Auth\AuthController;

class RegisterController extends AuthController
{
    /**
     * @Routing(url = 'register')
     * @AfterMiddleware(name = 'UnsetSession')
     */
    public function actionIndex()
    {
        $this->twig('registration', [
            'title' => 'Регистрация',
            'brand' => 'AuthBundle'
        ]);
    }
}