<?php

namespace App\Auth\Controllers\PDO;

use App\Auth\AuthController;
use App\Auth\Helpers\AlertHelper;
use App\Auth\Validations\LoginValidation;

class LoginController extends AuthController
{

    use AlertHelper;
    use LoginValidation;

    /**
     * @Routing(url = 'login')
     * @AfterMiddleware(name = 'UnsetSession')
     */
    public function actionIndex()
    {
        $this->twig('login', ['title' => 'Авторизация', 'brand' => 'Авторизация']);
    }

    /**
     * @Routing(url = 'login', method = 'POST')
     */
    public function actionLogin()
    {
        $this->validate();

        if ($this->isValid) {
            $user = $this->model()->getUser($this->validated['email']);
            $this->notRegistered($user);
            $this->login(
                $this->validated['password'], ['password' => $user->password, 'email' => $user->email], ''
            );
        }

        $this->errorMessages();
    }

    /**
     * @Routing(url = 'logout')
     */
    public function actionLogout()
    {
        $this->logout();
    }
}
