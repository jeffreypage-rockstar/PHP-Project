<?php namespace App\Http\Controllers\Api\v1;

use App\Dubb\Repos\EloquentUserRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\GetUsers;
use App\Http\Requests\UpdateUser;
use Illuminate\Http\Request;

class UserController extends Controller {

	protected $user;

	public function __construct(EloquentUserRepository $user)
	{
		$this->user = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param GetUsers $request
	 * @return Response
	 */
	public function index(GetUsers $request)
	{
		try {
			// Create new listing
			return $request->formatResponse($this->user->getAll($request));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {

			\Log::debug($e);
			return $request->formatResponse('Unable to connect to User API.', true, 400);

		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @param GetUsers $request
	 * @return Response
	 */
	public function show($id, GetUsers $request)
	{
		try {
			// Create new listing
			return $request->formatResponse($this->user->get($id));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to User API.', true, 400);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param UpdateUser $request
	 * @return Response
	 */
	public function update($id, UpdateUser $request)
	{
		try {
			// update existing user
			$request->merge(['id' => $id]);
			return $request->formatResponse($this->user->update($request));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the User API.', true, 400);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @param GetUsers $request
	 * @return Response
	 */
	public function destroy($id, GetUsers $request)
	{
		try {
			// Create new user
			return $request->formatResponse($this->user->delete($id));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Listing API.', true, 400);
		}
	}

}
