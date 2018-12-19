<?php

namespace App\Auth\Models\PDO;

use Rudra\Model;

class Users extends Model
{

    public function getUser(string $name)
    {
        $user = $this->db()->prepare('SELECT * FROM users WHERE `email` = :name');
        $user->execute([':name' => $name]);
        $user = $user->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function create(array $res)
    {
        $this->createRow($res);
        $this->setSession('alert', 'Данные добавлены', 'success');
        $this->setSession('alert', 'Подтвердите почтовый адрес', 'info');
    }

    public function updateActivate(array $res)
    {
        $query = $this->db()->prepare("
                UPDATE `users` SET 
                activate = :activate, 
                WHERE `email` = :email");

        $query->execute([
            ':activate' => $res['activate'],
            ':email'    => $res['email'],
        ]);

        $this->setSession('alert', 'Ссылка отправлена', 'success');
        $this->setSession('alert', 'Перейдите по ссылке', 'info');
    }

    public function updatePassword(array $res)
    {
        $query = $this->db()->prepare("
                UPDATE `users` SET 
                password = :password
                WHERE `email` = :email");

        $query->execute([
            ':password' => $res['password'],
            ':email'    => $res['email'],
        ]);

        $this->setSession('alert', 'Ссылка отправлена', 'success');
        $this->setSession('alert', 'Перейдите по ссылке', 'main');
    }

    /**
     * @param string $email
     */
    public function updateStatus(string $email)
    {
        $query = $this->db()->prepare("
                UPDATE `users` SET 
                status = :status
                WHERE `email` = :email");

        $query->execute([
            ':status' => '1',
            ':email'  => $email,
        ]);
    }

    protected function createRow(array $res)
    {
        $query = $this->db()->prepare("               
               INSERT INTO `users` (`name`, `email`, `password`, `role`, `status`, `activate`, `created_at`) 
               VALUES (:name, :email, :password, :role, :status, :activate, :created_at)");

        $query->execute([
            ':name'       => $res['name'],
            ':email'      => $res['email'],
            ':password'   => $res['password'],
            ':role'       => '2',
            ':status'     => '0',
            ':activate'   => $res['activate'],
            ':created_at' => date('Y-m-d H:i')
        ]);
    }
}
