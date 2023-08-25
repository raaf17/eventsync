<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1 Data
        // $data = [
        //     'name_user' => 'Administrator',
        //     'email_user'    => 'kipli.dev@email.com',
        //     'password_user'    => password_hash('12345678', PASSWORD_BCRYPT),
        // ];

        // Multi Data
        $data = [
            [
                'name_user' => 'Kipli Dev',
                'email_user'    => 'kipli.developer@gmail.com',
                'password_user'    => password_hash('1sampai8', PASSWORD_BCRYPT),
            ],
            [
                'name_user' => 'Admin 2',
                'email_user'    => 'johndoe@gmail.com',
                'password_user'    => password_hash('12345678', PASSWORD_BCRYPT),
            ],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
