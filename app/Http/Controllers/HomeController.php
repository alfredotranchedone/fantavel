<?php namespace App\Http\Controllers;

use App\Calendario;
use App\Classifica;
use App\Player;
use App\Result;
use App\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

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

        $user = Auth::user();

        $nextData = 0;
        $nextLimite = 0;

        $next = Calendario::nextMatches()->get();
        $last = Calendario::lastMatches()->get();

        $nextGiornata = Calendario::nextGiornata()->first();
        $lastGiornata = Calendario::lastGiornata()->first();

        $classifica = Classifica::getClassifica();


        if(!$next->isEmpty())
            $nextData = $next->first()->dataGiornata;

        if(!$last->isEmpty())
            $nextLimite =  $next->first()->dataConsegna;

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

                $user_team_id = Team::UserTeamId($user->id)->first()->id;
                $media = Result::AverageResult($user_team_id)->first()->media;

                return view('pages.users.home', ['player_count' => Player::count(),
                    'team_count' => Team::count(),
                    'nextMatches' => $next,
                    'lastMatches' => $last,
                    'nextGiornata' => $nextGiornata,
                    'lastGiornata' => $lastGiornata,
                    'classifica' => $classifica,
                    'dataGiornata' => $dg,
                    'dataConsegna' => $dc,
                    'media' => $media
                ]);
                break;

        }
    }

}
