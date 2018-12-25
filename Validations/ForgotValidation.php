<?php

namespace App\auth\Validations;

trait ForgotValidation
{

    protected function validate(string $key = 'access')
    {
        $validate = [
            'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
            'email'      => $this->validation()->email($this->post('email'))->run(),
        ];

        $result = [
            'access' => $this->validation()->access($validate),
            'data'   => $this->validation()->get($validate, ['csrf_field']),
            'all'    => $validate
        ];

        return $result[$key];
    }
}
