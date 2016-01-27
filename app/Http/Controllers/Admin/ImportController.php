<?php

namespace App\Http\Controllers\Admin;

use App\Formation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Player;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller {


	public function index()
	{

        return view('pages.admin.import.index',[
            'player_count' => Player::count(),
            'teams' => Team::all()
        ]);

	}


    public function player(Request $request)
    {
        $this->validate($request,[
           'nominativo' => 'required',
           'ruolo' => 'required',
           'codice' => 'required|numeric|unique:players,codice',
           'teams_id' => 'numeric'
        ],[
            'required' => 'Il campo :attribute è richiesto.',
            'numeric' => 'Il campo :attribute deve essere un numero.',
            'codice.unique' => 'Il Codice deve essere unico.',
        ]);

        $player = new Player();
        $player->nominativo = $request->nominativo;
        $player->ruolo = $request->ruolo;
        $player->codice = $request->codice;
        $player->teams_id = $request->teams_id;

        if($player->save()) {
            return redirect('admin/import')
                ->with('message', 'Calciatore aggiunto Correttamente!')
                ->with('messageType', 'success');
        } else {
            return redirect('admin/import')
                ->with('message', 'Upload NON Eseguito!')
                ->with('messageType','warning');
        }

    }


    public function upload(Request $request)
	{

        if( $request->input('confirmText') == 'UPLOAD' ):

            $destinationPath = 'uploads';
            $f = $request->file('xls');

            if ($f->isValid())
            {


                /**
                 * TODO aggiungere opzione per accodare o sovrascrivere i dati presenti.
                 * Nel caso dell'accodamento, magari controllare se esistono duplicati.
                 */

                // Elimina dati presenti
                DB::table('players')->delete();

                $name = date('Y.m.d_') . $f->getClientOriginalName();

                $f->move($destinationPath,$name);

                Excel::load('uploads/'.$name, function($reader) {

                    $reader->noHeading();

                    $reader->skip(2);

                    $results = $reader->get();

                    /*
                     * Schema .xls Gazzetta:
                     *   0 => "Cod."
                     *   1 => "Giocatore"
                     *   2 => "Squadra"
                     *   3 => "Ruolo"
                     *   4 => "Stato"
                     *   5 => "Quotazione"
                     *   6 => "Magic Punti"
                     *   7 => "Voto Pagella"
                     *   8 => "Gol"
                     *   9 => "Ammonizione"
                     *   10 => "Espulsione"
                     *   11 => "Rigore Par/Sbag."
                     *   12 => "Autorete"
                     *   13 => "Assist"
                    */


                    foreach($results as $row){
                        Player::create([
                            'nominativo' => $row[1],
                            'ruolo' => $row[3], // con trequartista
                            // 'ruolo' => $row[4], // senza trequartista
                            'codice' => $row[0]
                        ]);
                    }


                });



            }


            return redirect('admin/import')
                ->with('message', 'Importazione Eseguita Correttamente!')
                ->with('messageType','success');

        else:

            return redirect('admin/import')
                ->with('message', 'Upload NON Eseguito!')
                ->with('messageType','warning');

        endif;

	}


}
