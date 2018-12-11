<?php

namespace App\Auth\Models\PDO;

use Rudra\Model;

class Users extends Model
{

    public function getUser(string $name)
    {
        $users = $this->db()->prepare('SELECT * FROM users WHERE `email` = :name');

        $users->execute([
            ':name' => $name,
        ]);

        return $users->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $res)
    {
        $this->createRow($res);
        $this->setSession('alert', 'Данные добавлены', 'success');
    }

    protected function createRow(array $res)
    {
        $query = $this->db()->prepare("               
               INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`) 
               VALUES (:name, :email, :password, :role, :created_at)");

        $query->execute([
            ':name'       => $res['name'],
            ':email'      => $res['email'],
            ':password'   => $res['password'],
            ':role'       => '2',
            ':created_at' => date('Y-m-d H:i')
        ]);
    }
}
