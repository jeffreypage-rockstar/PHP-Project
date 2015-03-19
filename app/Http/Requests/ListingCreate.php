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
			'upsell' => 'required'
		];

		if($this->request->has('upsell')) {
			foreach($this->request->get('upsell') as $key=>$values) {
				$rules['upsell'.$key.'description'] = 'required';
				$rules['upsell'.$key.'price'] = 'required';
			}
		}

		return $rules;

	}

}
