<?php namespace App\Http\Controllers\Api\v1;

use App\Dubb\Repos\EloquentCategoryRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategory;
use App\Http\Requests\GetCategories;
use App\Http\Requests\UpdateCategory;


class CategoryController extends Controller {

	protected $category;

	public function __construct(EloquentCategoryRepository $category)
	{
		$this->category = $category;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param GetCategories $request
	 * @return Response
	 */
	public function index(GetCategories $request)
	{
		try {

			//Get All
			return $request->formatResponse($this->category->getAll($request));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Category API.', true, 400);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateCategory $request
	 * @return Response
	 */
	public function store(CreateCategory $request)
	{
		try {

			//Get All
			return $request->formatResponse($this->category->create($request));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Category API.', true, 400);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @param GetCategories $request
	 * @return Response
	 */
	public function show($id, GetCategories $request)
	{
		try {
			// Create new listing
			return $request->formatResponse($this->category->get($id));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Category API.', true, 400);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param UpdateCategory $request
	 * @return Response
	 */
	public function update($id, UpdateCategory $request)
	{
		try {
			// update existing user
			$request->merge(['id' => $id]);
			return $request->formatResponse($this->category->update($request));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Category API.', true, 400);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @param GetCategories $request
	 * @return Response
	 */
	public function destroy($id, GetCategories $request)
	{
		try {
			// Create new user
			return $request->formatResponse($this->category->delete($id));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Category API.', true, 400);
		}
	}

}
