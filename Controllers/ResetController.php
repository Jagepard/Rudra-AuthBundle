<?php

namespace App\Auth\Controllers;

use App\Auth\AuthController;

class ResetController extends AuthController
{

    /**
     * @Routing(url = 'reset/{email}/{md5}')
     */
    public function actionIndex($params)
    {
        $this->twig('reset', [
            'title' => 'Сброс пароля',
            'brand' => 'AuthBundle',
            'email' => trim($params['email']),
            'hash'  => trim($params['md5'])
        ]);
    }

    /**
     * @Routing(url = 'reset', method = 'POST')
     */
    public function actionReset()
    {
        $validate = [
            'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
            'email'      => $this->validation()->email($this->post('email'))->run(),
            'md5'        => $this->validation()->sanitize($this->post('hash'))->required('Заполните пароль')->run(),
            'password'   => $this->validation()
                ->sanitize($this->post('password'))
                ->minLength(5)->maxLength(20)
                ->required('Заполните пароль')->run()
        ];

        if ($this->validation()->access($validate)) {
            $res             = $this->validation()->get($validate, ['csrf_field']);
            $res['password'] = $this->bcrypt($res['password']);
            $user            = $this->model()->getUser($res['email']);

            if ($res['md5'] == $user['activate']) {
                $this->model()->updatePassword($user['email']);
                $this->setSession('alert', 'Пароль изменен', 'success');
                $this->redirect('login');
            }
        }
    }
}
