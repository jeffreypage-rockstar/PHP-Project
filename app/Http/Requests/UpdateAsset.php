<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateAsset extends Request {

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
			'object'=>'sometimes|required',
			'object_id'=>'sometimes|required|numeric',
			'name' => 'sometimes|required',
			'url' => 'sometimes|required|url',
			'type' => 'sometimes|required|in:image,video,file,audio,other'
		];
	}

}
