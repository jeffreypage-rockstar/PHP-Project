<?php namespace App\Http\Controllers\Api\v1;

use App\Dubb\Exceptions\GenericException;
use App\Dubb\Repos\EloquentAssetRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAsset;
use App\Http\Requests\GetAssets;
use App\Http\Requests\UpdateAsset;


class AssetController extends Controller {

	protected $asset;

	public function __construct(EloquentAssetRepository $asset)
	{
		$this->asset = $asset;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param GetAssets $request
	 * @return Response
	 */
	public function index(GetAssets $request)
	{
		try {

			//Get All
			return $request->formatResponse($this->asset->getAll($request));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Asset API.', true, 400);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateAsset $request
	 * @return Response
	 */
	public function store(CreateAsset $request)
	{
		try {

			//Get All
			return $request->formatResponse($this->asset->create($request));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Asset API.', true, 400);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @param GetAssets $request
	 * @return Response
	 */
	public function show($id, GetAssets $request)
	{
		try {
			// Create new listing
			return $request->formatResponse($this->asset->get($id));

		} catch ( GenericException $e) {

			return $request->formatResponse([$e->getMessage()], true, 400);

		} catch ( \Exception $e) {
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to Asset API.', true, 400);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param UpdateAsset $request
	 * @return Response
	 */
	public function update($id, UpdateAsset $request)
	{
		try {
			// update existing user
			$request->merge(['id' => $id]);
			return $request->formatResponse($this->asset->update($request));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Asset API.', true, 400);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @param GetAssets $request
	 * @return Response
	 */
	public function destroy($id, GetAssets $request)
	{
		try {
			// Create new user
			return $request->formatResponse($this->asset->delete($id));

		} catch ( GenericException $e) {
			\DB::rollback();
			return $request->formatResponse([$e->getMessage()], true, 400);
		} catch ( \Exception $e) {
			\DB::rollback();
			\Log::debug($e);
			return $request->formatResponse('Unable to connect to the Asset API.', true, 400);
		}
	}

}
