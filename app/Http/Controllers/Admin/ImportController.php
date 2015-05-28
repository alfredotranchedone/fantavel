<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Player;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller {


	public function index()
	{

        return view('pages.admin.import.index',['player_count' => Player::count()]);

	}


    public function upload(Request $request)
	{

        if( $request->input('confirmText') == 'UPLOAD' ):

            $destinationPath = 'uploads';
            $f = $request->file('xls');

            if ($f->isValid())
            {
                $name = date('Y.m.d_') . $f->getClientOriginalName();

                $f->move($destinationPath,$name);

                Excel::load('uploads/'.$name, function($reader) {

                    $reader->noHeading();

                    $reader->skip(3);

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
                            'ruolo' => $row[3],
                            'codice' => $row[0]
                        ]);
                    }


                });



            }

            echo 'INSERTED!';

        else:

            return redirect('admin/import')
                ->with('message', 'Upload NON Eseguito!')
                ->with('messageType','warning');

        endif;

	}


}
