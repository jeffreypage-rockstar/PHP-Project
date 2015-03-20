<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ListingCreate extends Request {

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
			'name' => 'required',
			'description' => 'sometimes| required',
			'category_id' => 'required',
			'user_id'	=> 'required',
			'lat' => 'required',
			'long' => 'required',
			'addon' => 'required|array'
		];

		if($this->request->has('addon') && is_array($this->request->get('addon'))) {
			for($i=0; $i<count($this->request->get('addon'));$i++) {
				$rules["addon.{$i}.id"] = 'sometimes|required';
				$rules["addon.{$i}.price"] = 'required';
				$rules["addon.{$i}.description"] = 'required';
			}
		}

		return $rules;

	}

}
