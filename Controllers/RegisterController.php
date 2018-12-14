<?php

namespace App\Auth\Controllers;

use App\Auth\AuthController;
use App\Web\Supports\CommonHelper;
use App\Auth\Models\PDO\Users as PDO;
use App\Auth\Models\Eloquent\Users as Eloquent;
use App\Auth\Models\Doctrine\Entity\Users as Doctrine;

class RegisterController extends AuthController
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
            'name'       => $this->validation()
                ->sanitize($this->post('name'))
                ->minLength(5)->maxLength(30)
                ->required('Заполните поле :: Имя пользователя')->run(),
            'email'      => $this->validation()->email($this->post('email'))->run(),
            'password'   => $this->validation()
                ->sanitize($this->post('password'))
                ->minLength(5)->maxLength(20)
                ->required('Заполните пароль')->run()
        ];

        /* Если установлен флаг remember_me */
        if ($this->container()->hasPost('agree')) {
            if ($this->validation()->access($validate)) {
                $res             = $this->validation()->get($validate, ['csrf_field']);
                $res['password'] = $this->bcrypt($res['password']);
                $res['activate'] = md5($this->randomString());

                switch ($this->container()->config('database', 'active')) {
                    case 'pdo':
                        if ($this->model()->getUser($res['email'])) {
                            $this->setSession('alert', 'Пользователь с таким Email уже есть', 'unique');
                            $this->redirect('register');
                        }

                        $this->model()->create($res);
                        $this->sendMail($res['email'], $res['activate']);
                        break;
//                    case 'doctrine':
//                        $user = $this->model()->findOneByEmail($res['email']);
//                        break;
//                    case 'eloquent':
//                        $user = Eloquent::find($res['email'])->first();
//                        break;
                }

                $this->redirect('login');
                return;
            }

            $this->validationErrors($validate);
            $this->redirect('register');
        }

        $this->setSession('alert', 'Вы не согласились с правилами ресурса', 'agree');
        $this->redirect('register');
    }
}
