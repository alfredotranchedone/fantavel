<?php

namespace App\Http\Controllers\Admin;

use App\Calendario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AjaxController extends Controller {


	public function index()
	{

	}



    public function postSaveDataGiornata(Request $request){

        $data = $request->input('data_submit');
        $time = $request->input('time_submit');
        $dataGiornata = $data . ' ' . $time . ':00';
        $giornataID = $request->input('giornata');

        DB::table('calendario')
            ->where('giornata', $giornataID)
            ->update(['dataGiornata' => $dataGiornata]);

    }


}
