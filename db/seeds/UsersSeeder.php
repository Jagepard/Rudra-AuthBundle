<?php

use Carbon\Carbon;
use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->insert('users', [
            'name'       => 'Admin',
            'email'      => 'admin@admin.com',
            'password'   => '$2y$10$IgxFxFx5RLWmST9H6THQ/eCWT71mZgGwN.PeABJ0vHimQnrqyjAWS',
            'status'     => 1,
            'role'       => 1,
            'activate'   => null,
            'created_at' => Carbon::now(),
        ]);
    }
}
