<?php
/**
 * Created by alfredo
 * Date: 11/08/15
 * Time: 17:51
 */

namespace App;


use Illuminate\Support\Facades\DB;

class Setup {



    public static function check()
    {

        $calendario = DB::table('calendario')->select('id')->count();
        $players = DB::table('players')->select('id')->count();
        $teams = DB::table('teams')->select('id')->count();

        $check = array(
            'teams' => $teams,
            'players' => $players,
            'calendario' => $calendario,
        );

        return $check;

        debug($check);

    }


}