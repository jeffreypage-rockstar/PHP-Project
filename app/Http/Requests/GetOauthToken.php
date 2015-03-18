<?php namespace App\Http\Requests;

use App\Http\Requests\Request as Request;

class GetOauthToken extends Request {

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
			'client_signature'=>'required',
			'scope' => 'required|in:all,mobile,read',
			'response_type'=> 'required|in:token',
			'grant_type'=> 'required|in:client_credentials'
		];
	}

	public function forbiddenResponse()
	{
		$template = [
			'error' => true,
			'response' => 'Permission denied !'
			];
		return \Response::make($template, 403);
	}

	public function response(array $errors)
	{
		if (count($errors) < 1 ) {
			$template = [
				'error' => false,
				'response' => [
					'token' => hash('sha256', rand(1, 2999)),
					'expires_in' => 84000
				]
			];
			return \Response::make($template, 200);
		}else{
			$template = [
				'error' => true,
				'response' => [
					$this->formatErrors($this->getValidatorInstance())
				]
			];
			return \Response::make($template, 400);
		}

	}


}
