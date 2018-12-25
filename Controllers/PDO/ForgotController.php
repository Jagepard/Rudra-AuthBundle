<?php

namespace App\Auth\Controllers\PDO;

use App\Auth\AuthController;
use App\auth\Validations\ForgotValidation;

class ForgotController extends AuthController
{

    use ForgotValidation;

    /**
     * @Routing(url = 'forgot')
     */
    public function actionIndex()
    {
        $this->twig('forgot', ['title' => 'Восстановление пароля', 'brand' => 'Восстановление пароля']);
    }

    /**
     * @Routing(url = 'forgot', method = 'POST')
     */
    public function actionForgot()
    {
        $this->validate();

        if ($this->isValid) {
            $this->validated['activate'] = md5($this->randomString());
            $this->model()->updateActivate($this->validated);
            $this->sendMail($this->validated['email'], $this->validated['activate'], 1);
            $this->redirect('login');
        }

        $this->validationErrors($this->validate);
        $this->redirect('forgot');
    }
}
