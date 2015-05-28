<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserRequest extends Request {

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
		return [
            'nome' => 'required|max:155',
            'email' => 'required|email|unique:users|max:155',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'attivo' => 'required',
            'team' => 'required|max:155|unique:teams,name',
		];
	}

}
