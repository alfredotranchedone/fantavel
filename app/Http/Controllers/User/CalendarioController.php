<?php

namespace App\Http\Controllers\User;

use App\Calendario;
use App\Formation;
use App\Http\Controllers\Controller;
use App\Result;
use Illuminate\Support\Facades\DB;


class CalendarioController extends Controller {


	public function getIndex()
	{


        $all = Calendario::allMatches()->get()->toArray();

        // raggruppa i risultati per giornata
        $groups = array();
        foreach ($all as $item) {
            $key = $item['giornata'];
            $fc = $item['fattore_campo'];
            $dG = $item['dataGiornata'];
            $dC = $item['dataConsegna'];
            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'incontri'=>array($item),
                    'giornata'=>$key,
                    'dataGiornata'=> $dG,
                    'dataConsegna'=> $dC,
                    'fattore_campo' => $fc
                ];
            } else {
                $groups[$key]['incontri'][] = $item;
                $groups[$key]['giornata'] = $key;
                $groups[$key]['dataGiornata'] = $dG;
                $groups[$key]['dataConsegna'] = $dC;
                $groups[$key]['fattore_campo'] = $fc;

            }
        }

        return view('pages.users.calendario.show',[
                'all' => $groups
            ]);

	}



    public function getMatch($calendarioId)
    {

        $match = Calendario::
        select(DB::raw(
            'calendario.*,
                                t1.name as team_1_nome,
                                t2.name as team_2_nome,
                                t1.user_id as team_1_user_id,
                                t2.user_id as team_2_user_id
                                '
        ))
            ->leftJoin('teams as t1', 't1.id', '=', 'calendario.team_1_id')
            ->leftJoin('teams as t2', 't2.id', '=', 'calendario.team_2_id')
            ->where('calendario.id',$calendarioId)->first();

        $team_1_result = Result::leftJoin('moduli', 'moduli.id', '=', 'results.modulo_id')
            ->where('teams_id',$match->team_1_id)
            ->where('giornata',$match->giornata)
            ->first();
        $team_2_result = Result::leftJoin('moduli', 'moduli.id', '=', 'results.modulo_id')
            ->where('teams_id',$match->team_2_id)
            ->where('giornata',$match->giornata)
            ->first();

        $team_1_players = Formation::
        leftJoin('players','players.codice','=','formations.players_codice')
            ->leftJoin('punteggi',function($join) use ($match){
                $join
                    ->on('punteggi.players_codice','=','formations.players_codice')
                    ->on('punteggi.giornata','=',$match->giornata);
            })
            ->where('formations.teams_id',$match->team_1_id)
            ->where('formations.giornata_id',$match->giornata)
            ->where('formations.players_codice','!=',0)
            ->get();

        $team_2_players = Formation::
        leftJoin('players','players.codice','=','formations.players_codice')
            ->leftJoin('punteggi',function($join) use ($match){
                $join
                    ->on('punteggi.players_codice','=','formations.players_codice')
                    ->on('punteggi.giornata','=',$match->giornata);
            })
            ->where('formations.teams_id',$match->team_2_id)
            ->where('formations.giornata_id',$match->giornata)
            ->where('formations.players_codice','!=',0)
            ->get();

        // dd($team_1_result,$team_2_result,$team_1_players);

        return view('pages.users.calendario.dettaglio',[
            'match' => $match,
            'team_1_result' => $team_1_result,
            'team_2_result' => $team_2_result,
            'team_1_players' => $team_1_players,
            'team_2_players' => $team_2_players,
        ]);

    }

}
