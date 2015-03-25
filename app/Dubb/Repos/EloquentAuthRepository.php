<?php namespace App\Dubb\Repos;

use App\Dubb\Exceptions\ApiException;
use App\Dubb\Exceptions\GenericException;
use App\Entities\User;
use App\Dubb\Contracts\AuthInterface;
use App\Dubb\Contracts\Client;
use App\Http\Requests\SignIn;
use App\Http\Requests\SignUp;
use Illuminate\Support\Facades\Hash;

class EloquentAuthRepository implements AuthInterface
{

    protected $user;

    /**
     *  Private and Protected methods on top.
     */
    /**
     * @param $request
     * @param $user
     * @return mixed
     * @throws GenericException
     */
    private function _loginAttempt($request, $user)
    {
        if (isset($request['password']) && Hash::check($request['password'], $user->password)) {
            return $user;
        }
        foreach (['facebook_token', 'gplus_token', 'twitter_token'] as $token) {

            // I have a token
            if (isset($request[$token]) && ($request[$token] == $user->getAttribute($token))) {
                // social login attempt successful
                return $user;
            }

            // I have a new token, update the token
            if (isset($request[$token]) && ($user->getAttribute($token) != '' || $user->getAttribute($token) == null)) {

                $user->setAttribute($token, $request[$token]);
                $user->save();

                return $user;
            }
        }

        throw new GenericException('Email/Username already registered.');
    }

    /**
     *  All Public Methods Next
     */

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getOauthToken(Client $client)
    {
        // TODO: Implement getOauthToken() method.
    }

    /**
     * @param SignUp $requestObj
     * @return mixed|static
     */
    public function signUpIfNotExisting(SignUp $requestObj)
    {
        // get all the request data
        $request = $requestObj->all();

        // get the email from the request
        $user = null;

        if (isset($request['email'])){
            $user = $this->user->where('email', $request['email'])->first();
        }

        if(isset($request['username'])) {
            $user = $this->user->where('username', $request['username'])->first();
        }


        if ($user) {
            // User already registered
            // So attempting to sign in the user.

            return $this->_loginAttempt($request, $user);
        }

        // create new user
        $request['password'] = bcrypt($request['password']);

        $user = User::create($request);

        return $user;

    }


    /**
     * @param SignIn $requestObj
     * @return mixed
     * @throws GenericException
     */
    public function authenticate(SignIn $requestObj)
    {
       $request = $requestObj->all();

       $user = $this->user->where('email', $request['email'])->first();

       if ($user && Hash::check($request['password'], $user->password)) {

           return $user;
       }

       throw new ApiException('Authentication Failed');
    }
}