<?php

namespace App\Auth\Validations;

trait ForgotValidation
{

    protected $isValid;
    protected $validate;
    protected $validated;

    protected function validate(): void
    {
        if (!isset($this->validate)) {
            $this->validate = [
                'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
                'email'      => $this->validation()->email($this->post('email'))->run(),
            ];

            $this->isValid   = $this->validation()->access($this->validate);
            $this->validated = $this->validation()->get($this->validate, ['csrf_field']);
        }
    }
}
