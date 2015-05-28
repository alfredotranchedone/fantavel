<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Session;

class EditTeamRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{

        Session::keep(['uid']);

        $validation_array = [
            'nomeTeam' => 'required|max:155',
        ];

		return $validation_array;
	}

}
