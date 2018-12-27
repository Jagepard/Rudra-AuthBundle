<?php

namespace App\Auth\Models\PDO;

use Rudra\Container;
use Rudra\Model;

class Users extends Model
{

    public static function user()
    {
        if (Container::$app->hasSession('user')) {
            return (new self(Container::$app))->getUser(Container::$app->getSession('user'));
        }
    }

    public function getUser(string $name)
    {
        $user = $this->db()->prepare('SELECT * FROM users WHERE `email` = :name');
        $user->execute([':name' => $name]);
        $user = $user->fetch(\PDO::FETCH_OBJ);

        return $user;
    }

    public function create(array $res)
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
}
