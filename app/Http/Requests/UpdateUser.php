<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUser extends Request {

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
			'email'=>'sometimes|required|email',
			'first'=>'sometimes|required',
			'last'=> 'sometimes|required',
			'username' => 'sometimes|required|alpha_num',
			'password' => 'sometimes|required',
			'facebook_token' => 'sometimes|required',
			'twitter_token' => 'sometimes|required',
			'gplus_token' =>'sometimes|required',
		];
	}

}
