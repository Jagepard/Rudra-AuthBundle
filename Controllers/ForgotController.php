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
            'brand' => 'AuthBundle'
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
            $res             = $this->validation()->get($validate, ['csrf_field']);
            $res['activate'] = md5($this->randomString());

            switch ($this->container()->config('database', 'active')) {
                case 'pdo':
                    $this->model()->updateActivate($res);
                    $this->sendMail($res['email'], $res['activate'], 1);
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
        $this->redirect('forgot');
    }
}
