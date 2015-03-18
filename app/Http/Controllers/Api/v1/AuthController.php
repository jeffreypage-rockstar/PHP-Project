<?php namespace App\Http\Controllers\Api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;

class AuthController extends Controller {

	public function getToken(Requests\GetOauthToken $request)
	{
		return $request->response([]);
	}

}
