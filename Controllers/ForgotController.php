<?php

namespace App\Auth\Controllers;

use App\Auth\AuthController;

class ForgotController extends AuthController
{

    /**
     * @Routing(url = 'forgot')
     */
    public function actionIndex()
    {
        $this->twig('forgot', [
            'title' => 'Восстановление пароля',
            'brand' => 'Восстановление пароля'
        ]);
    }

    /**
     * @Routing(url = 'forgot', method = 'POST')
     */
    public function actionForgot()
    {
        $validate = [
            'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
            'email'      => $this->validation()->email($this->post('email'))->run(),
        ];

        if ($this->validation()->access($validate)) {
            $data             = $this->validation()->get($validate, ['csrf_field']);
            $data['activate'] = md5($this->randomString());

            $this->switchModel($this->container()->config('database', 'active'), $data);
            $this->redirect('login');
        }

        $this->validationErrors($validate);
        $this->redirect('forgot');
    }

    protected function switchModel(string $driver, array $data): void
    {
        switch ($driver) {
            case 'pdo':
                $this->model()->updateActivate($data);
                $this->sendMail($data['email'], $data['activate'], 1);
                break;
//                    case 'doctrine':
//                        $user = $this->model()->findOneByEmail($data['email']);
//                        break;
//                    case 'eloquent':
//                        $user = Eloquent::find($data['email'])->first();
//                        break;
        }
    }
}
