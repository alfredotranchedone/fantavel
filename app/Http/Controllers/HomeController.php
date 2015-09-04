<?php namespace App\Http\Controllers;

use App\Calendario;
use App\Classifica;
use App\Player;
use App\Result;
use App\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Setup;
use App\Fantavel\Utilities;
use App\Fantavel\Scrape;

class HomeController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		 $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

        Carbon::setLocale('it');

        $user = Auth::user();

        $nextData = 0;
        $nextLimite = 0;

        $next = Calendario::nextMatches()->get();
        $last = Calendario::lastMatches()->get();

        if( $next->isEmpty() ){
            //dd('campionato finito');
        }

        $nextGiornata = Calendario::nextGiornata()->first();
        $lastGiornata = Calendario::lastGiornata()->first();

        $classifica = Classifica::getClassifica();

        if(!$next->isEmpty()) {

            $nextData = $next->first()->dataGiornata;

            if(!$last->isEmpty())
                $nextLimite =  $next->first()->dataConsegna;

        } else {
            $nextData = false;
        }


        $dg = false;
        $dc = false;

        if($nextData > 0) {
            $d = new Carbon();
            $dg = $d->createFromTimestamp(strtotime($nextData))
                ->format('d/m/Y H:i:s');
        }

        if($nextLimite>0) {
            $c = new Carbon();
            $dc = $c->createFromTimestamp(strtotime($nextLimite))
                ->format('d/m/Y H:i:s');
        }


        /**
         * TODO bugfix
         *
        */


        switch ($user->levels_level) {

            case 0:
                return view('pages.home', ['player_count' => Player::count(),
                'team_count' => Team::count(),
                'nextMatches' => $next,
                'lastMatches' => $last,
                'nextGiornata' => $nextGiornata,
                'lastGiornata' => $lastGiornata,
                'classifica' => $classifica,
                'dataGiornata' => $dg,
                'dataConsegna' => $dc
                ]);
                break;

            case 100:
            default:

                $canSubmitFormation = Utilities::canSubmitFormation($dc);


                $user_team_id = Team::UserTeamId($user->id)->first()->id;
                $media = Result::AverageResult($user_team_id)->first()->media;

                /* controlla andamento */
                    $andamento = Classifica::andamento($user_team_id)->toArray();

                    // var da mostrare in home
                    $posizione_precedente = false;

                    // andamento stabile - DEFAULT
                    $variazione_andamento = 0;

                    if(count($andamento)>1){

                        $posizione_precedente = $andamento[0]['posizione'];

                        if($andamento[1]['posizione'] > $andamento[0]['posizione']){
                            // andamento positivo
                            $variazione_andamento = 1;
                        } elseif($andamento[1]['posizione'] < $andamento[0]['posizione']) {
                            // andamento negativo
                            $variazione_andamento = -1;
                        }
                    }


                return view('pages.users.home', ['player_count' => Player::count(),
                    'team_count' => Team::count(),
                    'nextMatches' => $next,
                    'lastMatches' => $last,
                    'nextGiornata' => $nextGiornata,
                    'lastGiornata' => $lastGiornata,
                    'classifica' => $classifica,
                    'dataGiornata' => $dg,
                    'dataConsegna' => $dc,
                    'media' => $media,
                    'variazione_andamento' => $variazione_andamento,
                    'posizione_precedente' => $posizione_precedente,
                    'canSubmitFormation' => $canSubmitFormation
                ]);
                break;

        }
    }

}
