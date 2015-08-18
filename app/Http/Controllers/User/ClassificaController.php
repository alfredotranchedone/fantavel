<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;



class ClassificaController extends Controller {


	public function getIndex()
	{

        return view('pages.users.classifica.show');

	}


}
