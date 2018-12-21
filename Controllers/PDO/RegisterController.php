<?php

namespace App\Auth\Controllers\PDO;

use App\Auth\AuthController;
use App\Auth\Models\Eloquent\Users as Eloquent;

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
            'brand' => 'Регистрация'
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
                ->minLength(5, 'Имя пользователя слишком мало')->maxLength(30, 'Имя пользователя слишком длинное')->run(),
            'email'      => $this->validation()->email($this->post('email'), 'Почта указана неверно')->run(),
            'password'   => $this->validation()
                ->sanitize($this->post('password'))
                ->minLength(5, 'Пароль слишком мал')->maxLength(20, 'Пароль слишком большой')->run()
        ];

        /* Если установлен флаг agree */
        if ($this->container()->hasPost('agree')) {
            if ($this->validation()->access($validate)) {
                $data             = $this->validation()->get($validate, ['csrf_field']);
                $data['password'] = $this->bcrypt($data['password']);
                $data['activate'] = md5($this->randomString());

                $this->switchModel($this->container()->config('database', 'active'), $data);
                $this->sendMail($data['email'], $data['activate']);
                $this->redirect('login');
            }

            $this->validationErrors($validate);
            $this->redirect('register');
        }

        $this->setSession('alert', 'Вы не согласились с правилами ресурса', 'agree');
        $this->redirect('register');
    }

    protected function switchModel(string $driver, array $data): void
    {
        switch ($driver) {
            case 'pdo':
                if ($this->model()->getUser($data['email'])) {
                    $this->setSession('alert', 'Пользователь с таким Email уже есть', 'unique');
                    $this->redirect('register');
                }

                $this->model()->create($data);
                break;
//                    case 'doctrine':
//                        $user = $this->model()->findOneByEmail($res['email']);
//                        break;
//                    case 'eloquent':
//                        $user = Eloquent::find($res['email'])->first();
//                        break;
        }
    }
}
