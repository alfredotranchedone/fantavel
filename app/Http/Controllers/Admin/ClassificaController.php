<?php namespace App\Http\Controllers\Admin;

use App\Calendario;
use App\Classifica;
use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClassificaController extends Controller {

    public function index()
    {

        $groups_name = false;
        $classifica = Classifica::getClassifica();
        $last_giornata = Calendario::lastGiornata()->first()->giornata;
        $groups = Classifica::getGruppo();

        if(!is_null($groups)) {
            $groups_id = $groups->first()->gruppo;
            $groups_name = Group::find($groups_id)->first(['name'])->name;
        }

        return view('pages.admin.classifica.index',[
            'classifica' => $classifica,
            'groups' => $groups,
            'groups_name' => $groups_name,
        ]);

    }

}