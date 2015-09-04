<?php

namespace App\Http\Controllers\Admin;

use App\Classifica;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;

use App\Team;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $users = User::with('teams')->attivi()->noAdmin()->get();
        //$users = User::with('teams')->get();

        return view('pages.admin.users.index', ['users' => $users]);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('pages.admin.users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateUserRequest $request)
	{
        // crea utente
        $user = new User;
        $user->name = $request->input('nome');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->attivo = $request->input('attivo');
        $user->levels_level = 100;
        $user->save();

        // recupera l'id dell'utente inserito
        $lastInsertedId = $user->id;

        // crea team
        $team = new Team;
        $team->name = $request->input('team');
        $team->user_id = $lastInsertedId;
        $team->save();

        // recupera l'id del team inserito
        $lastInsertedIdTeam = $team->id;

        // popola classifica
        $classifica = new Classifica();
        $classifica->team_id = $lastInsertedIdTeam;
        $classifica->save();

        return redirect('admin/user')->with('message', 'User Created!');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

        $user = User::find($id);
        $team = Team::where('user_id',$id)->first();
		return view('pages.admin.users.show',['user'=>$user,'team'=>$team]);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = User::find($id);
        //$team = Team::where('user_id',$id)->first();
        return view('pages.admin.users.edit',['user'=>$user]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
     * @param  CreateUserRequest  $request
	 * @return Response
	 */
	public function update(EditUserRequest $request, $id)
	{

        $user = User::find($id);

        $user->name = $request->input('nome');
        $user->email = $request->input('email');
        if($request->input('password'))
            $user->password = bcrypt($request->input('password'));
        $user->attivo = $request->input('attivo');
        $user->save();

        return redirect('admin/user/'.$id)->with('message', 'User Updated!');

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

            $user = User::find($id);
            $user->delete();

            return redirect('admin/user')
                ->with('message', 'User DELETED!')
                ->with('messageType','success');

        endif;

        return redirect('admin/user/'.$id.'/edit')
            ->with('message', 'User NOT DELETED!')
            ->with('messageType','warning');

	}

}
