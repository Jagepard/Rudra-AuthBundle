<?php

namespace App\Auth\Validations;

trait ResetValidation
{

    protected $isValid;
    protected $validate;
    protected $validated;

    protected function validate(): void
    {
        if (!isset($this->validate)) {
            $this->validate = [
                'csrf_field' => $this->validation()->sanitize($this->post('csrf_field'))->csrf()->run(),
                'email'      => $this->validation()->email($this->post('email'), 'Почта указана неверно')->run(),
                'md5'        => $this->validation()->sanitize($this->post('hash'))->required('Заполните пароль')->run(),
                'password'   => $this->validation()
                    ->sanitize($this->post('password'))
                    ->minLength(5, 'Пароль слишком мал')->maxLength(20, 'Пароль слишком большой')->run()
            ];

            $this->isValid   = $this->validation()->access($this->validate);
            $this->validated = $this->validation()->get($this->validate, ['csrf_field']);
        }
    }
}
