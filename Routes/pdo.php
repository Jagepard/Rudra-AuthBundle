<?php

return [
    'login'                  => ['PDO\LoginController'],
    'login::POST'            => ['PDO\LoginController', 'actionLogin'],
    'logout'                 => ['PDO\LoginController', 'actionLogout'],
    'register'               => ['PDO\RegisterController'],
    'register::POST'         => ['PDO\RegisterController', 'actionRegister'],
    'activate/{email}/{md5}' => ['PDO\ActivateController', 'actionActivate'],
    'forgot'                 => ['PDO\ForgotController'],
    'forgot::POST'           => ['PDO\ForgotController', 'actionForgot'],
    'reset/{email}/{md5}'    => ['PDO\ResetController'],
    'reset::POST'            => ['PDO\ResetController', 'actionReset'],
];