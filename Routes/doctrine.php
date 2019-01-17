<?php

return [
    'login'                  => ['LoginController'],
    'login::POST'            => ['LoginController', 'actionLogin'],
    'logout'                 => ['LoginController', 'actionLogout'],
    'register'               => ['RegisterController'],
    'register::POST'         => ['RegisterController', 'actionRegister'],
    'activate/{email}/{md5}' => ['ActivateController', 'actionActivate'],
    'forgot'                 => ['ForgotController'],
    'forgot::POST'           => ['ForgotController', 'actionForgot'],
    'reset/{email}/{md5}'    => ['ResetController'],
    'reset::POST'            => ['ResetController', 'actionReset'],
];