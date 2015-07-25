<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class UtilityController extends Controller {


	public function getIndex()
	{



	}

    public function getDatabase()
	{

        $trans = array("formations" => "formazioni", "players" => "calciatori", "results" => "risultati");

        // array tabelle da resettare
        $tablesList = ['classifica','formations','players','punteggi','results','teams'];

        return view('pages.admin.utility.database')->with([
            'tablesList' => $tablesList,
            'trans' => $trans
        ]);

	}


    public function postDatabase(Request $request, $action){

        $tbl = $request->input('tbl');

        switch($action){
            case 'reset':
                if($this->resetTable($tbl)){
                    return redirect('utility/database')
                        ->with('message', 'LE TABELLE SONO STATE SVUOTATE!')
                        ->with('messageType','warning');
                }
            break;

        }

    }



    private function resetTable($tableName){

        if($tableName=='stagione'){

            DB::table('calendario')->truncate();
            DB::table('classifica')->truncate();
            DB::table('formations')->truncate();
            DB::table('players')->truncate();
            DB::table('punteggi')->truncate();
            DB::table('results')->truncate();

            return true;

        }

    }

}
