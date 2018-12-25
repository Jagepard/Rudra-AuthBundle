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

    protected function errorMessages()
    {
        $this->validationErrors($this->validate);
        $this->redirect('login');
    }
}
