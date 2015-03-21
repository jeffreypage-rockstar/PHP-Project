<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\UserInterface;
use App\Dubb\Exceptions\GenericException;
use App\Entities\User;
use App\Http\Requests\GetUsers;
use App\Http\Requests\UpdateUser;

class EloquentUserRepository implements UserInterface
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function get($id)
    {
        $user = $this->user->find($id);

        if (is_null($user)) {
            throw new GenericException('User with ID:'.$id. ' not found.');
        }

        return $user;
    }

    /**
     * @param GetUsers $requestObj
     * @return mixed
     */
    public function getAll(GetUsers $requestObj)
    {
        $request = $requestObj->all();

        // get listing module
        $user = $this->user;

        // if requesting related models add them
        $user = $requestObj->loadRelatedModels($user);

        // Get the paginated result
        $user = $requestObj->paginateResponse($user);

        return $user;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function delete($id)
    {
        $deleted = $this->user->destroy($id) > 0;

        if (! $deleted) {
            throw new GenericException('User with ID '. $id. ' not available.');
        }

        return $deleted;
    }

    /**
     * @param UpdateUser $requestObj
     * @return mixed
     * @throws GenericException
     */
    public function update(UpdateUser $requestObj)
    {
        $request = $requestObj->all();
        $user = $this->user->find($request['id']);

        if (is_null($user)) {
            throw new GenericException('Error Updating Listing');
        }

        foreach($request as $key=>$val) {
            $user->setAttribute($key, $val);
        }

        return $user->save();
    }
}