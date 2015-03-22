<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\TagInterface;
use App\Dubb\Exceptions\GenericException;
use App\Entities\Tag;
use App\Http\Requests\CreateTag;
use App\Http\Requests\GetTags;
use App\Http\Requests\UpdateTag;
use Illuminate\Support\Facades\DB;

class EloquentTagRepository implements TagInterface
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function get($id)
    {
        $tag = $this->tag->find($id);

        if (is_null($tag)) {
            throw new GenericException('Tag with ID:'.$id. ' not found.');
        }

        return $tag;
    }

    /**
     * @param GetTags $requestObj
     * @return mixed
     */
    public function getAll(GetTags $requestObj)
    {
        // get listing module
        $tag = $this->tag;

        // if requesting related models add them
        $tag = $requestObj->loadRelatedModels($tag);

        // Get the paginated result
        $tag = $requestObj->paginateResponse($tag);

        return $tag;
    }

    /**
     * @param CreateTag $requestObj
     * @return mixed
     */
    public function create(CreateTag $requestObj)
    {
        // Begin Transaction
        DB::beginTransaction();

        //Create the listing
        $tag = $this->tag->create($requestObj->all());

        DB::commit();

        return $tag;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function delete($id)
    {
        $deleted = $this->tag->destroy($id) > 0;

        if (! $deleted) {
            throw new GenericException('Tag with ID '. $id. ' not available.');
        }

        return $deleted;
    }

    /**
     * @param UpdateTag $requestObj
     * @return mixed
     * @throws GenericException
     */
    public function update(UpdateTag $requestObj)
    {
        $request = $requestObj->all();
        $tag = $this->tag->find($request['id']);


        if (is_null($tag)) {
            throw new GenericException('Error Updating Tag');
        }

        foreach($request as $key=>$val) {
            $tag->setAttribute($key, $val);
        }

        return $tag->save();
    }
}