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
        $user = $this->db()->prepare('SELECT * FROM users WHERE `email` = :email');
        $user->execute([
            ':email' => $params['email'],
        ]);
        $user = $user->fetch(\PDO::FETCH_ASSOC);

        if ($user['status'] == '1') {
            $this->setSession('alert', $user['email'] . ' - уже активирован', 'main');
            $this->redirect('login');
        }

        if ($params['md5'] == $user['activate']) {
            $this->updateStatus($user['email']);
            $this->setSession('alert', 'Email подтвержден', 'success');
            $this->redirect('login');
        }

        $this->setSession('alert', 'Ссылка неверна', 'main');
        $this->redirect('login');
    }

    /**
     * @param string $email
     */
    protected function updateStatus(string $email)
    {
        $query = $this->db()->prepare("
                UPDATE `users` SET 
                status = :status
                WHERE `email` = :email");

        $query->execute([
            ':status' => '1',
            ':email'  => $email,
        ]);
    }
}
