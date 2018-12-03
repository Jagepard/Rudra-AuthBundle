<?php

return [
    'login'       => ['LoginController'],
    'login::POST' => ['LoginController', 'actionLogin'],
    'logout'      => ['LoginController', 'actionLogout']
];