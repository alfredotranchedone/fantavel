<?php
/**
 * Created by alfredo
 * Date: 27/01/16
 * Time: 18:26
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Player;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Players extends Controller{


    public function getIndex()
    {

        return view('pages.users.players.index',[
            'players' => Player::with('teams')->get()
        ]);
    }


}