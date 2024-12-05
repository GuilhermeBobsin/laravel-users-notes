<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //criar usuários manualmente
        DB::table('users')->insert([
            [
                'username' => 'usuario1@gmail.com',
                'password' => bcrypt('111111'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'usuario2@gmail.com',
                'password' => bcrypt('111111'),
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'usuario3@gmail.com',
                'password' => bcrypt('111111'),
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
