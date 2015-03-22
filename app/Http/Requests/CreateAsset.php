<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateAsset extends Request {

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
			'object'=>'required',
			'object_id'=>'required',
			'name' => 'required',
			'url' => 'required|url',
			'type' => 'required|in:image,video,file,audio,other'
		];
	}

}
