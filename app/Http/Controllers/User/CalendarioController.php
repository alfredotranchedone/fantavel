<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;



class CalendarioController extends Controller {


	public function getIndex()
	{

        return view('pages.users.calendario.show');

	}


}
