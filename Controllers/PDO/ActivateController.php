<?php

namespace App\Auth\Controllers\PDO;

use App\Auth\AuthController;
use App\auth\Helpers\AlertHelper;

class ActivateController extends AuthController
{

    use AlertHelper;

    /**
     * @Routing(url = 'activate/{email}/{md5}')
     */
    public function actionActivate($params)
    {
        $user = $this->model()->getUser($params['email']);
        $this->notRegistered($user);
        $this->alreadyActivated($user);

        if ($params['md5'] == $user->activate) {
            $this->model()->updateStatus($user->email);
            $this->succeeded();
        }

        $this->wrongLink();
    }
}
