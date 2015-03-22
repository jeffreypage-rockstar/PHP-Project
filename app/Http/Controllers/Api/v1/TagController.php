<?php namespace App\Http\Controllers\Api\v1;

use App\Dubb\Exceptions\GenericException;
use App\Dubb\Repos\EloquentTagRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTag;
use App\Http\Requests\GetTags;
use App\Http\Requests\UpdateTag;


class TagController extends Controller {

	protected $tag;

	public function __construct(EloquentTagRepository $tag)
	{
		$this->tag = $tag;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param GetTags $request
	 * @return Response
	 */
	public function index(GetTags $request)
	{
		try {

			//Get All
			return $request->formatResponse($this->tag->getAll($request));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Tag API.', true, 400);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateTag $request
	 * @return Response
	 */
	public function store(CreateTag $request)
	{
		try {

			//Get All
			return $request->formatResponse($this->tag->create($request));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Tag API.', true, 400);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @param GetTags $request
	 * @return Response
	 */
	public function show($id, GetTags $request)
	{
		try {
			// Create new listing
			return $request->formatResponse($this->tag->get($id));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Tag API.', true, 400);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param UpdateTag $request
	 * @return Response
	 */
	public function update($id, UpdateTag $request)
	{
		try {
			// update existing user
			$request->merge(['id' => $id]);
			return $request->formatResponse($this->tag->update($request));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Tag API.', true, 400);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @param GetTags $request
	 * @return Response
	 */
	public function destroy($id, GetTags $request)
	{
		try {
			// Create new user
			return $request->formatResponse($this->tag->delete($id));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Tag API.', true, 400);
		}
	}

}
