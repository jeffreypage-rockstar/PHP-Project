<?php namespace App\Http\Controllers\Api\v1;

use App\Dubb\Exceptions\GenericException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Dubb\Repos\EloquentAuthRepository as EloquentAuthRepository;
use Response;

class AuthController extends Controller {

	public function getToken(Requests\GetOauthToken $request)
	{
		return $request->response([]);
	}

	/**
	 * SignUp API will authenticate if the user has passed existing credentials and return
	 * The correct user obj or else it will create a new User.
	 *
	 * @param Requests\SignUp $request
	 * @param EloquentAuthRepository $user
	 * @return array
	 */
	public function signUp(Requests\SignUp $request, EloquentAuthRepository $user)
	{
		try {

			return $request->formatResponse($user->signUpIfNotExisting($request));

		}catch(GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		}catch(\Exception $e) {
			\Log::error($e);
			return $request->formatResponse('Unable to connect to the AuthController@signUp.', true, 400);

		}
	}

	/**
	 * SignIn API
	 * @param Requests\SignIn $request
	 * @param EloquentAuthRepository $user
	 * @return array
	 */
	public function signIn(Requests\SignIn $request, EloquentAuthRepository $user)
	{
		try {

			return $request->formatResponse($user->authenticate($request));

		}catch (GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		}catch(\Exception $e) {
			\Log::error($e);
			return $request->formatResponse('Unable to connect to the AuthController@signIn.', true, 400);

		}
	}

}
