<?php namespace App\Http\Requests;

use App\Http\Requests\Request as Request;

class SignUp extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'email'=>'required|email',
			'first'=>'required',
			'last'=> 'required',
			'username' => 'sometimes|alpha_num',
			'password' => 'sometimes|required_without_all: facebook_token, twitter_token, gplus_token',
			'facebook_token' => 'sometimes|required_without_all: password, twitter_token, gplus_token',
			'twitter_token' => 'sometimes|required_without_all: password, facebook_token, gplus_token',
			'gplus_token' => 'sometimes|required_without_all: password, twitter_token, facebook_token',
			'preferences' => 'sometimes|required|array'
		];

		if($this->request->has('preferences') && is_array($this->request->get('preferences'))) {
			for($i=0; $i<count($this->request->get('preferences'));$i++) {
				$rules["preferences.{$i}.id"] = 'required_if:'."preferences.{$i}.delete,true";
				$rules["preferences.{$i}.delete"] = 'sometimes|required|boolean';
				$rules["preferences.{$i}.key"] = 'sometimes|required';
				$rules["preferences.{$i}.value"] = 'sometimes|required';
			}
		}

		return $rules;
	}

}
