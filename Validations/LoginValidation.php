<?php
/**
 * @author    : Korotkov Danila <dankorot@gmail.com>
 * @copyright Copyright (c) 2018, Korotkov Danila
 * @license   http://www.gnu.org/licenses/gpl.html GNU GPL-3.0
 */

namespace App\Auth\Validations;

trait LoginValidation
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
                'password'   => $this->validation()->sanitize($this->post('password'))
                    ->minLength(5, 'Пароль слишком мал')->maxLength(20, 'Пароль слишком большой')->run()
            ];

            $this->isValid   = $this->validation()->access($this->validate);
            $this->validated = $this->validation()->get($this->validate, ['csrf_field']);
        }
    }
}
