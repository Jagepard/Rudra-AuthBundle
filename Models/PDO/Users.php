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

        return $users->fetchObject();
    }
}
