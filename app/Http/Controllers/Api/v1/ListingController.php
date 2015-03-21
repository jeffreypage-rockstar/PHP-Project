<?php namespace App\Http\Controllers\Api\v1;

use App\Dubb\Exceptions\GenericException;
use App\Dubb\Repos\EloquentListingRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ListingCreate;

class ListingController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @param Requests\ListingGetAll $request
	 * @param EloquentListingRepository $listing
	 * @return Response
	 */
	public function index(Requests\ListingGetAll $request, EloquentListingRepository $listing)
	{
		try {
			// Create new listing
			return $request->formatResponse($listing->getAll($request));

		} catch ( GenericException $e) {
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Listing API.', true, 400);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ListingCreate $request
	 * @param EloquentListingRepository $listing
	 * @return Response
	 */
	public function store(ListingCreate $request, EloquentListingRepository $listing)
	{
		try {
			// Create new listing
			return $request->formatResponse($listing->create($request));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Listing API.', true, 400);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @param Requests\ListingGetOne $request
	 * @param EloquentListingRepository $listing
	 * @return Response
	 */
	public function show($id, Requests\ListingGetOne $request, EloquentListingRepository $listing)
	{
		try {
			// Create new listing
			return $request->formatResponse($listing->get($id));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Listing API.', true, 400);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param Requests\ListingUpdate $request
	 * @param EloquentListingRepository $listing
	 * @return Response
	 */
	public function update($id, Requests\ListingUpdate $request, EloquentListingRepository $listing)
	{
		try {
			// update existing listing
			$request->merge(['id' => $id]);
			return $request->formatResponse($listing->update($request));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Listing API.', true, 400);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @param Requests\ListingGetOne $request
	 * @param EloquentListingRepository $listing
	 * @return Response
	 */
	public function destroy($id, Requests\ListingGetOne $request, EloquentListingRepository $listing)
	{
		try {
			// Create new listing
			return $request->formatResponse($listing->delete($id));

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
