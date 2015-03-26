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
    public function get($id, GetUsers $requestObj)
    {
        $user = $this->user;

        if (is_null($user)) {
            throw new GenericException('User with ID:'.$id. ' not found.');
        }

        $user = $requestObj->loadRelatedModels($user);

        return $user->find($id);
    }

    /**
     * @param GetUsers $requestObj
     * @return mixed
     */
    public function getAll(GetUsers $requestObj)
    {
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
            throw new GenericException('User not found with ID: '.$request['id']);
        }
        if (isset($request['password'])) {
            $request['password'] = \Hash::make($request['password']);
        }
        foreach($request as $key=>$val) {
            $user->setAttribute($key, $val);
        }

        $user->save();

        return $user;
    }
}