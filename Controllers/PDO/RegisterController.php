<?php

namespace App\Auth\Controllers\PDO;

use App\Auth\AuthController;
use App\Auth\Helpers\AlertHelper;
use App\Auth\Validations\RegisterValidation;

class RegisterController extends AuthController
{

    use AlertHelper;
    use RegisterValidation;

    /**
     * @Routing(url = 'register')
     * @AfterMiddleware(name = 'UnsetSession')
     */
    public function actionIndex()
    {
        $this->twig('registration', ['title' => 'Регистрация', 'brand' => 'Регистрация']);
    }

    /**
     * @Routing(url = 'register', method = 'POST')
     */
    public function actionRegister()
    {
        $this->validate();

        /* Если установлен флаг agree */
        if ($this->container()->hasPost('agree')) {
            if ($this->isValid) {
                $this->validated['password'] = $this->bcrypt($this->validated['password']);
                $this->validated['activate'] = md5($this->randomString());
                $this->alreadyExists($this->validated['email']);
                $this->sendMail($this->validated['email'], $this->validated['activate']);
                $this->redirect('login');
            }

            $this->errorMessages('register');
        }

        $this->notAgree();
    }
}
