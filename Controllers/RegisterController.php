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

    /**
     * @Routing(url = 'register', method = 'POST')
     */
    public function actionRegister()
    {
        $validate = [
            'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
            'name'       => $this->validation()->sanitize($this->post('email'))->required('Заполните поле :: Имя пользователя')->run(),
            'email'      => $this->validation()->sanitize($this->post('email'))->required('Заполните поле :: Email')->run(),
            'password'   => $this->validation()->sanitize($this->post('password'))->required('Заполните пароль')->run()
        ];

        dd($validate);

        if ($this->validation()->access($validate)) {

        }

        $this->validationErrors($validate);
        $this->validationErrors($validate, 'value');

        $this->redirect('login');
    }
}
