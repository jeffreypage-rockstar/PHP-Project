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

			return \Response::make($user->signUpIfNotExisting($request->all()), 400);
		}catch(\Exception $e){
			$request->response([$e->getMessage()]);
		}
	}

}
