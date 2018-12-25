<?php

namespace App\Auth\Controllers\PDO;

use App\Auth\AuthController;
use App\Auth\Helpers\AlertHelper;
use App\Auth\Validations\ForgotValidation;

class ForgotController extends AuthController
{

    use AlertHelper;
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

        $this->errorMessages('forgot');
    }
}
