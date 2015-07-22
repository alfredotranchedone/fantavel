<?php

namespace App\Http\Controllers\Admin;

use App\Calendario;
use Carbon\Carbon;
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
        $giornata = $request->input('giornata');

        $setDataConsegna = new Carbon($dataGiornata);
        $dataConsegna = $setDataConsegna->subMinute(1)->toDateTimeString();

        //debug($dataConsegna);

        DB::table('calendario')
            ->where('giornata', $giornata)
            ->update([
                'dataGiornata' => $dataGiornata,
                'dataConsegna' => $dataConsegna
            ]);

        return response()->json([
            'giornata' => $giornata,
            'dataGiornata' => $dataGiornata,
            'dataConsegna' => $dataConsegna
        ]);


    }

    public function postSaveDataConsegna(Request $request){

        $data = $request->input('data_submit');
        $time = $request->input('time_submit');
        $dataConsegna = $data . ' ' . $time . ':00';
        $giornata = $request->input('giornata');

        DB::table('calendario')
            ->where('giornata', $giornata)
            ->update(['dataConsegna' => $dataConsegna]);

    }


}
