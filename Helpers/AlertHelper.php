<?php

namespace App\Auth\Helpers;

trait AlertHelper
{

    protected function notRegistered($user): void
    {
        if (!$user) {
            $this->setSession('alert', 'Email не зарегистрирован', 'not-registered');
            $this->redirect('login');
        }
    }

    protected function alreadyActivated($user)
    {
        if ($user->status == '1') {
            $this->setSession('alert', 'Email уже активирован', 'info');
            $this->redirect('login');
        }
    }

    protected function wrongLink()
    {
        $this->setSession('alert', 'Ссылка неверна', 'error');
        $this->redirect('login');
    }

    protected function succeeded()
    {
        $this->setSession('alert', 'Email подтвержден', 'success');
        $this->redirect('login');
    }

    protected function errorMessages(string $target = 'login')
    {
        $this->validationErrors($this->validate);
        $this->redirect($target);
    }

    protected function notAgree()
    {
        $this->setSession('alert', 'Вы не согласились с правилами ресурса', 'agree');
        $this->redirect('register');
    }

    protected function alreadyExists(string $email)
    {
        if ($email) {
            $this->setSession('alert', 'Пользователь с таким Email уже есть', 'unique');
            $this->redirect('register');
        }
    }
}
