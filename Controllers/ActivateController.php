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
        $this->notRegistered($user);

        if ($user['status'] == '1') {
            $this->setSession('alert', 'Email уже активирован', 'info');
            $this->redirect('login');
        }

        if ($params['md5'] == $user['activate']) {
            $this->model()->updateStatus($user['email']);
            $this->setSession('alert', 'Email подтвержден', 'success');
            $this->redirect('login');
        }

        $this->setSession('alert', 'Ссылка неверна', 'error');
        $this->redirect('login');
    }
}
