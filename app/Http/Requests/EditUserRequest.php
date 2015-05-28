<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;

class EditUserRequest extends Request {

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

        $validation_array = [
            'nome' => 'required|max:155',
            'attivo' => 'required',
            'email' => 'required',
        ];

        $user = User::find($this->user);

        // se la password è stata inserita, allora valida i campi
        if( strlen(trim(Request::get('password'))) > 0 ){
            $validation_array['password'] = 'required';
            $validation_array['password_confirmation'] = 'required|same:password';
        }

        // se la mail è modificata, applica la validazione
        if($user->email != Request::get('email')){
            $validation_array['email'] = 'required|email|unique:users|max:155';
        }

		return $validation_array;
	}

}
