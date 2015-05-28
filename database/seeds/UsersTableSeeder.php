<?php

use App\User;

class UsersTableSeeder extends DatabaseSeeder {

    public function run()
    {
        DB::table('users')->delete();

       $data = [
           [
            'name' => 'admin',
            'email' => 'admin@talentsmanager.it',
            'password' => bcrypt('admin'),
            'attivo' => 1,
            'levels_level' => 0
            ],
            [
            'name' => 'test',
            'email' => 'test@test.it',
            'password' => bcrypt('qweqwe'),
            'attivo' => 1,
            'levels_level' => 100
            ]
        ];

        foreach($data as $d){
            User::create($d);
        }

    }

}