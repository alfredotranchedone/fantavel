<?php

use App\Level;

class LevelsTableSeeder extends DatabaseSeeder {

    public function run()
    {
        DB::table('levels')->delete();

        $levels = [
            [
            'name' => 'SuperAdmin',
            'level' => 0
            ],
            [
                'name' => 'User',
                'level' => 100
            ]
        ];

        foreach($levels as $level){
            Level::create($level);
        }

    }

}