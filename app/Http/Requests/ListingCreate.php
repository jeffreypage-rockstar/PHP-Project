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
			'upsell' => 'required|array'
		];

		if($this->request->has('upsell') && is_array($this->request->get('upsell'))) {
			for($i=0; $i<count($this->request->get('upsell'));$i++) {
				$rules["upsell.{$i}.price"] = 'required';
				$rules["upsell.{$i}.description"] = 'required';
			}
		}

		return $rules;

	}

}
