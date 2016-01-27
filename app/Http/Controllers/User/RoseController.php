<?php

namespace App\Http\Controllers\User;

use App\Calendario;
use App\Classifica;
use App\Fantavel\Utilities;
use App\Formation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Moduli;
use App\Player;
use App\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class RoseController extends Controller {


	public function getIndex()
	{

        $usid = Auth::user()->id;
        $teamId = Team::select(['id'])->where('user_id',$usid)->first()->id;

        $players = Player::with('formazione')->where('teams_id',$teamId)->get();

        $team = Team::find($teamId,['name','modulo_id']);

        $moduli = Moduli::all()->sortByDesc('modificatore');

        $prossima_giornata = Calendario::nextGiornata()->first()->giornata;
        $giornataInfo = Calendario::where('giornata',$prossima_giornata)->first();
        $dataGiornata = $giornataInfo->dataGiornata;
        $dataConsegna = $giornataInfo->dataConsegna;

        $players = Player::with(['formazione' => function($q) use ($prossima_giornata){
                $q->where('giornata_id',$prossima_giornata);
            }])
            ->where('teams_id',$teamId)
            ->get();


        $formazione = Formation::where('teams_id',$teamId)
            ->where('numero_maglia','>',0)

                // da controllare
                ->where('giornata_id',$prossima_giornata)

            ->orderBy('numero_maglia')
            ->get();



        // se formazione è vuota...
        if($formazione->isEmpty()){

            // ...prendi formazione dell'ultima giornata

            $players = Player::with(['formazione' => function($q) use ($prossima_giornata){
                $q->where('giornata_id',$prossima_giornata - 1);
            }])
                ->where('teams_id',$teamId)
                ->get();

            $formazione = Formation::where('teams_id',$teamId)
                ->where('numero_maglia','>',0)

                // da controllare
                ->where('giornata_id',$prossima_giornata - 1)

                ->orderBy('numero_maglia')
                ->get();
        }



        $vars = [
            'players' => $players,
            'teamId' => $teamId,
            'team' => $team,
            'formazione' => $formazione,
            'moduli' => $moduli,
            'prossima_giornata' => $prossima_giornata,
            'data_giornata' => $dataGiornata,
            'data_consegna' => $dataConsegna,
        ];

        $canSubmitFormation = Utilities::canSubmitFormation($dataConsegna,'Y-m-d H:i:s');
        /*
        if($prossima_giornata == 1){
            return view('pages.users.rose.formazione_index', $vars);
        }
        */

        if($canSubmitFormation) {
            return view('pages.users.rose.formazione_index', $vars);
        } else {
            Carbon::setLocale('it');
            if($dataConsegna) {
                $scadenza = Carbon::now('Europe/Rome')->diffForHumans(Carbon::createFromFormat('Y-m-d H:i:s', $dataConsegna), true);
            } else {
                $scadenza = 0;
            }
            $vars['scadenza'] = $scadenza;
            return view('pages.users.rose.formazione_no_submit', $vars);
        }


	}




    public function postIndex(Request $request){


        //$codici = $request->get('codice');
        $teamId = $request->get('team_id');
        $numero_maglia = $request->get('numero_maglia');
        $prossima_giornata = $request->get('prossima_giornata');
        $cleanData = Formation::where('teams_id', '=', $teamId)
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

        return redirect('user/formazione')
            ->with('message','Formazione Salvata')
            ->with('messageType','success');

    }



    public function postSaveModulo(Request $request){

        $modulo = $request->get('modulo');
        $teamId = $request->get('team_id');

        $m = Team::find($teamId);
        $m->modulo_id = $modulo;
        $m->save();

        return redirect('user/formazione')
            ->with('msg','Modulo Salvato!')
            ->with('type','success');

    }


/*
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
*/

    public function rosa()
    {

        $usid = Auth::user()->id;
        $team_info = Team::select(['name','id'])->where('user_id',$usid)->first();
        $players = Player::where('teams_id',$team_info->id)->get();

        return view('pages.users.rose.show',[
            'team' => $team_info,
            'players' => $players,
        ]);

    }


    
    
}
