<?php namespace App\Http\Controllers\Admin;

use App\Calendario;
use App\Classifica;
use App\Group;
use App\Http\Controllers\Controller;

class ClassificaController extends Controller {

    public function index()
    {

        $minicampionati = [];
        $classifica = Classifica::getClassifica();
        $groups = Classifica::getGruppo();

        /*
        if(!empty($groups)){

            $groups->each(function($group) use ($minicampionati){
                $minicampionati[] = Classifica::getGruppo($group->id);
            });

        }
        */

        dd($groups);

        return view('pages.admin.classifica.index',[
            'classifica' => $classifica,
            'groups' => $groups,
        ]);

    }

}