<?php namespace App\Http\Controllers\Admin;

use App\Classifica;
use App\Http\Requests;
use App\Http\Requests\EditTeamRequest;
use App\Http\Controllers\Controller;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class TeamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return view();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        Session::keep(['uid']);
        return view('pages.admin.teams.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EditTeamRequest $request)
	{

        // se uid è null
        if( ! Crypt::decrypt($request->input('uid')) ) :

            return redirect()
                ->back()
                ->with('message', 'Si è verificato un errore (uid)')
                ->with('messageType', 'warning')
                ->withInput();
        endif;

        $team = new Team;
        $team->name = $request->input('nomeTeam');
        $team->user_id = Crypt::decrypt($request->input('uid'));
        $team->save();

        // aggiungi team a classifica
        $classifica = new Classifica();
        $classifica->team_id = $team->id;
        $classifica->save();

        return redirect('admin/user')
            ->with('message', 'Team Creato!')
            ->with('messageType','success');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $team = Team::find($id);
        return view('pages.admin.teams.edit',['team'=>$team]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditTeamRequest $request, $id)
	{

		$team = Team::find($id);
        $team->name = $request->input('nomeTeam');
        $team->save();

        return redirect('admin/user/'.$team->user_id)
            ->with('message', 'Team Updated!')
            ->with('messageType','success');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy(Request $request, $id)
    {

        if($request->input('confirmDelete') == 'DELETE'):

            $team = Team::find($id);
            $team->delete();

            $classificaId = Classifica::where('team_id',$id)->first();
            if($classificaId):
                $classifica = Classifica::find($classificaId->id);
                $classifica->delete();
            endif;

            return redirect('admin/user')
                ->with('message', 'Team DELETED!')
                ->with('messageType','success');

        endif;

        return redirect('admin/user')
            ->with('message', 'Team NOT DELETED!')
            ->with('messageType','warning');

    }

}
