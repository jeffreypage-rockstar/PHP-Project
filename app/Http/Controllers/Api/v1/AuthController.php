<?php namespace App\Http\Controllers\Api\v1;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Dubb\Repos\EloquentAuthRepository as EloquentAuthRepository;
use Response;

class AuthController extends Controller {

	public function getToken(Requests\GetOauthToken $request)
	{
		return $request->response([]);
	}

	public function signUp(Requests\SignUp $request, EloquentAuthRepository $user)
	{
		try {
			$template = [
				'error'=> false,
				'response' => $user->signUpIfNotExisting($request->all())
			];
			return \Response::make($template, 200);
		}catch(\Exception $e){
			$request->response([$e->getMessage()]);
		}
	}

}
