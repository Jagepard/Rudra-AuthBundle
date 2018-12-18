<?php

namespace App\Auth\Controllers;

use App\Auth\AuthController;

class ActivateController extends AuthController
{

    /**
     * @Routing(url = 'activate/{email}/{md5}')
     */
    public function actionActivate($params)
    {
        $user = $this->model()->getUser($params['email']);

        if ($user['status'] == '1') {
            $this->setSession('alert', $user['email'] . ' - уже активирован', 'main');
            $this->redirect('login');
        }

        if ($params['md5'] == $user['activate']) {
            $this->model()->updateStatus($user['email']);
            $this->setSession('alert', 'Email подтвержден', 'success');
            $this->redirect('login');
        }

        $this->setSession('alert', 'Ссылка неверна', 'main');
        $this->redirect('login');
    }
}
