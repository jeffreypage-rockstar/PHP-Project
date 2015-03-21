<?php namespace App\Http\Controllers\Api\v1;

use App\Dubb\Repos\EloquentUserRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\GetUsers;
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
