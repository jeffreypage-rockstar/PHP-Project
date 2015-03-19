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
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * @return Response
	 * @internal param ListingCreate $request
	 * @internal param EloquentListingRepository $listing
	 */
	public function create()
	{

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
			dd($request->all());
		} catch ( GenericException $e) {

		} catch ( \Exception $e) {

		}
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
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
