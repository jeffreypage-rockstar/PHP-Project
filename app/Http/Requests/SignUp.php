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
			'username' => 'sometimes|required'
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
			$template = [
				'error' => true,
				'response' => [
					$this->formatErrors($this->getValidatorInstance())
				]
			];
			return \Response::make($template, 400);

	}
}
