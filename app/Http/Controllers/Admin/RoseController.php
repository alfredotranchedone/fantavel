<?php

namespace App\Http\Controllers\Admin;

use App\Calendario;
use App\Classifica;
use App\Formation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Moduli;
use App\Player;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class RoseController extends Controller {


	public function getIndex()
	{

        $teams = Team::all();
        $classifica = Classifica::getClassifica();

        return view('pages.admin.rose.index',[
            'teams' => $teams,
            'classifica' => $classifica,
        ]);

	}



    public function getFormazione($teamId){

        $prossima_giornata = Calendario::nextGiornata()->first()->giornata;

        $players = Player::where('teams_id',$teamId)->get();
        $team = Team::find($teamId,['name','modulo_id']);
        $formazione = Formation::where('teams_id',$teamId)
            ->where('numero_maglia','>',0)
            ->orderBy('numero_maglia')
            ->get();
        $moduli = Moduli::all()->sortByDesc('modificatore');

        return view('pages.admin.rose.formazione_index',[
            'players' => $players,
            'teamId' => $teamId,
            'team' => $team,
            'formazione' => $formazione,
            'moduli' => $moduli,
            'prossima_giornata' => $prossima_giornata
        ]);

    }

    public function postFormazione(Request $request){

        //$codici = $request->get('codice');
        $teamId = $request->get('team_id');
        $prossima_giornata = $request->get('prossima_giornata');
        $numero_maglia = $request->get('numero_maglia');

        $cleanData = Formation::where('teams_id', $teamId)
            ->where('giornata_id',$prossima_giornata)
            ->delete();



        foreach($numero_maglia as $numero=>$codice){

            $player = new Formation();
            $player->teams_id = $teamId;
            $player->giornata_id = $prossima_giornata;
            $player->players_codice = $codice;
            $player->numero_maglia = $numero;
            $player->save();

        }

        return redirect('admin/rose/formazione/'.$teamId)
            ->with('msg','Formazione Salvata')
            ->with('type',' success');

    }



    public function postSaveModulo(Request $request){

        $modulo = $request->get('modulo');
        $teamId = $request->get('team_id');

        $m = Team::find($teamId);
        $m->modulo_id = $modulo;
        $m->save();

        return redirect('admin/rose/formazione/'.$teamId)
            ->with('msg','Modulo Salvato!')
            ->with('type','success');

    }



    public function anyAssign(Request $request, $id)
    {

        if ($request->isMethod('post'))
        {

            $codici_players = $request->input('cods');
            $team_id = $request->input('tid');

            $resetRows = Player::where('teams_id',$team_id)->update(['teams_id' => 0]);

            if($codici_players)
                $affectedRows = Player::whereIn('codice',$codici_players)->update(['teams_id' => $team_id]);

        }

        $team = Team::find($id);
        $players = Player::all();
        $players_assigned = Player::where('teams_id',$team->id)->get();

        return view('pages.admin.rose.assign',[
            'team' => $team,
            'players' => $players,
            'players_assigned' => $players_assigned,
        ]);

    }



}
