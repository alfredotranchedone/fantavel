<?php

namespace App\Http\Controllers\User;

use App\Calendario;
use App\Classifica;
use App\Group;
use App\Http\Controllers\Controller;



class ClassificaController extends Controller {


	public function getIndex()
	{

        $groups_name = false;
        $last_giornata = Calendario::lastGiornata()->first()->giornata;
        $classifica = Classifica::getClassifica($last_giornata);
        $groups = Classifica::getGruppo($last_giornata);

        if( (!is_null($groups)) AND $classifica->count()>0 ) {
            $groups_id = $groups->first()->gruppo;
            $group = Group::find($groups_id);
            if($group>0)
                $groups_name = Group::find($groups_id)->first(['name'])->name;
        }

        return view('pages.users.classifica.show',[
            'giornata' => $last_giornata,
            'classifica' => $classifica,
            'groups' => $groups,
            'groups_name' => $groups_name,
        ]);

	}


}
