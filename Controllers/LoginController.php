<?php

namespace App\Auth\Controllers;

use App\Auth\AuthController;
use App\Web\Supports\CommonHelper;
use App\Auth\Models\PDO\Users as PDO;
use App\Auth\Models\Eloquent\Users as Eloquent;
use App\Auth\Models\Doctrine\Entity\Users as Doctrine;

class LoginController extends AuthController
{
    use CommonHelper;

    public function before()
    {
        switch ($this->container()->config('database', 'active')) {
            case 'pdo':
                $this->setModel(PDO::class);
                break;
            case 'doctrine':
                $this->model = $this->db()->getRepository(Doctrine::class);
                break;
        }
    }

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
            'brand' => 'AuthBundle'
        ]);
    }

    /**
     * @Routing(url = 'login', method = 'POST')
     */
    public function actionLogin()
    {
        $validate = [
            'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
            'email'      => $this->validation()->email($this->post('email'), " :: email")->required('Заполните поле :: Email')->run(),
            'password'   => $this->validation()->sanitize($this->post('password'))
                ->minLength(5)->maxLength(20)
                ->required('Заполните пароль')->run()
        ];

        if ($this->validation()->access($validate)) {
            $user = [];
            $res  = $this->validation()->get($validate, ['csrf_field']);

            switch ($this->container()->config('database', 'active')) {
                case 'pdo':
                    $user = $this->model()->getUser($res['email']);
                    break;
                case 'doctrine':
                    $user = $this->model()->findOneByEmail($res['email']);
                    break;
                case 'eloquent':
                    $user = Eloquent::find($res['email'])->first();
                    break;
            }

            $this->login($res['password'], $user, '');
            return;
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
}
