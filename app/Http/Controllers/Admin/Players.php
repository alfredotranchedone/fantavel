<?php
/**
 * Created by alfredo
 * Date: 27/01/16
 * Time: 18:26
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Player;
use App\Team;
use Illuminate\Http\Request;

class Players extends Controller{

    public function index()
    {
        return view('pages.admin.players.index',[
            'players' => Player::with('teams')->get()
        ]);
    }



    public function edit($id){
        return view('pages.admin.players.edit',[
            'player' => Player::where('codice',$id)->first(),
            'teams' => Team::all()
        ]);
    }



    public function update(Request $request,$id){

        if( $request->input('confirm') != 'CONFIRM' ) {
            return redirect()
                ->route('admin.players.edit', [$id])
                ->with('message', 'Operazione NON confermata!')
                ->with('messageType', 'warning');
        }

        $this->validate($request,[
            'nominativo' => 'required',
            'ruolo' => 'required',
            'codice' => 'required|numeric|unique:players,codice,'.$request->id,
            'teams_id' => 'numeric'
        ],[
            'required' => 'Il campo :attribute è richiesto.',
            'numeric' => 'Il campo :attribute deve essere un numero.',
            'codice.unique' => 'Il Codice deve essere unico.',
        ]);

        $player = Player::where('codice',$id)->first();
        $player->nominativo = $request->nominativo;
        $player->ruolo = $request->ruolo;
        $player->codice = $request->codice;
        $player->teams_id = $request->teams_id;

        if($player->save()) {
            return redirect()->route('admin.players.index')
                ->with('message', 'Calciatore modificato correttamente!')
                ->with('messageType', 'success');
        } else {
            return redirect()->route('admin.players.edit')
                ->with('message', 'Modifica NON Eseguita!')
                ->with('messageType','warning');
        }

    }


    public function destroy(Request $request,$id)
    {

        if( $request->confirmDelete != 'DELETE' ) {
            return redirect()
                ->route('admin.players.edit', [$id])
                ->with('message', 'Operazione NON confermata!')
                ->with('messageType', 'warning');
        }

        $player = Player::where('codice',$id)->first();

        if($player->delete()) {
            return redirect()->route('admin.players.index')
                ->with('message', 'Calciatore eliminato correttamente!')
                ->with('messageType', 'success');
        } else {
            return redirect()->route('admin.players.edit')
                ->with('message', 'Calciatore NON eliminato!')
                ->with('messageType','warning');
        }


    }

}