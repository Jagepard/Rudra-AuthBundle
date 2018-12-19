<?php

namespace App\Auth\Controllers;

use App\Auth\AuthController;
use App\Auth\Models\Eloquent\Users as Eloquent;

class LoginController extends AuthController
{

    /**
     * @Routing(url = 'login')
     * @AfterMiddleware(name = 'UnsetSession')
     *
     * php vendor/bin/doctrine orm:convert-mapping --namespace="App\\Auth\\Models\\Doctrine\\Entity\\" --force  --from-database annotation ./
     * php vendor/bin/doctrine orm:generate-entities ./ --generate-annotations=true﻿
     *
     * путь в cli-config.php app/auth/Models/Doctrine
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function actionIndex()
    {
        $this->twig('login', [
            'title' => 'Авторизация',
            'brand' => 'Авторизация'
        ]);
    }

    /**
     * @Routing(url = 'login', method = 'POST')
     */
    public function actionLogin()
    {
        $validate = [
            'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
            'email'      => $this->validation()->email($this->post('email'), 'Почта указана неверно')->run(),
            'password'   => $this->validation()->sanitize($this->post('password'))
                ->minLength(5, 'Пароль слишком мал')->maxLength(20, 'Пароль слишком большой')->run()
        ];

        if ($this->validation()->access($validate)) {
            $data = $this->validation()->get($validate, ['csrf_field']);
            $user = $this->switchModel($this->container()->config('database', 'active'), $data);
            $this->login($data['password'], $user, '');
        }

        $this->validationErrors($validate);
        $this->redirect('login');
    }

    /**
     * @Routing(url = 'logout')
     */
    public function actionLogout()
    {
        $this->logout();
    }

    protected function switchModel(string $driver, array $data): array
    {
        switch ($driver) {
            case 'pdo':
                $user = $this->model()->getUser($data['email']);
                $this->notRegistered($user);
                break;
            case 'doctrine':
                $user = $this->model()->findOneByEmail($data['email']);
                break;
            case 'eloquent':
                $user = Eloquent::find($data['email'])->first();
                break;
        }

        return $user;
    }
}
