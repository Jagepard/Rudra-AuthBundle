<?php

namespace App\Auth\Controllers\PDO;

use App\Auth\AuthController;
use App\Auth\Helpers\AlertHelper;
use App\Auth\Validations\ResetValidation;

class ResetController extends AuthController
{

    use AlertHelper;
    use ResetValidation;

    /**
     * @Routing(url = 'reset/{email}/{md5}')
     */
    public function actionIndex($params)
    {
        $user = $this->model()->getUser(trim($params['email']));
        $this->notRegistered($user);

        $this->twig('reset', [
            'title' => 'Сброс пароля',
            'brand' => 'Сброс пароля',
            'email' => trim($params['email']),
            'hash'  => trim($params['md5'])
        ]);
    }

    /**
     * @Routing(url = 'reset', method = 'POST')
     */
    public function actionReset()
    {
        $this->validate();

        if ($this->isValid) {
            $this->validated['password'] = $this->bcrypt($this->validated['password']);
            $user                        = $this->model()->getUser($this->validated['email']);

            if ($this->validated['md5'] == $user->activate) {
                $this->model()->updatePassword($this->validated);
                $this->setSession('alert', 'Пароль изменен', 'success');
                $this->redirect('login');
            }
        }

        $this->errorMessages();
    }
}
