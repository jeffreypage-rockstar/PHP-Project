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
		return [
			'email'=>'required|email',
			'first'=>'required',
			'last'=> 'required',
			'username' => 'sometimes|required',
			'password' => 'sometimes|required_without_all: facebook_token, twitter_token, gplus_token',
			'facebook_token' => 'sometimes|required_without_all: password, twitter_token, gplus_token',
			'twitter_token' => 'sometimes|required_without_all: password, facebook_token, gplus_token',
			'gplus_token' => 'sometimes|required_without_all: password, twitter_token, facebook_token',
		];
	}

}
