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

    protected function alreadyActivated($user): void
    {
        if ($user->status == '1') {
            $this->setSession('alert', 'Email уже активирован', 'info');
            $this->redirect('login');
        }
    }

    protected function wrongLink(): void
    {
        $this->setSession('alert', 'Ссылка неверна', 'error');
        $this->redirect('login');
    }

    protected function succeeded(): void
    {
        $this->setSession('alert', 'Email подтвержден', 'success');
        $this->redirect('login');
    }

    protected function errorMessages(string $target = 'login'): void
    {
        $this->validationErrors($this->validate);
        $this->redirect($target);
    }

    protected function notAgree(): void
    {
        $this->setSession('alert', 'Вы не согласились с правилами ресурса', 'agree');
        $this->redirect('register');
    }

    protected function alreadyExists($user): void
    {
        if ($user) {
            $this->setSession('alert', 'Пользователь с таким Email уже есть', 'unique');
            $this->redirect('register');
        }
    }

    protected function emailVerification(): void
    {
        $this->setSession('alert', 'Данные добавлены', 'success');
        $this->setSession('alert', 'Подтвердите почтовый адрес', 'info');
    }

    protected function sendLink(): void
    {
        $this->setSession('alert', 'Ссылка отправлена', 'success');
        $this->setSession('alert', 'Перейдите по ссылке', 'info');
    }
}
