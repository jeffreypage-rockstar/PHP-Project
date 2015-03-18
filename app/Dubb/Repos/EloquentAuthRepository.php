<?php namespace Dubb\Repos;

use Dubb\Contracts\AuthInterface;
use Dubb\Contracts\Client;
use Illuminate\Support\Facades\Hash;

class EloquentAuthRepository implements AuthInterface
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getOauthToken(Client $client)
    {
        // TODO: Implement getOauthToken() method.
    }

    public function signUpIfNotExisting($request)
    {

        // get the email from the request
        $email = $request['email'];

        // check if a user exists
        $user = $this->user->where('email', $email)->first();

        if ($user) {
            // User already registered
            // So attempting to sign in the user.

            return $this->_loginAttempt($request, $user);
        }else{
            // create new user
            return $this->user->create($request);
        }
    }

    /**
     * @param $request
     * @param $user
     * @return mixed
     */
    private function _loginAttempt($request, $user)
    {
        if (Hash::make($request['password']) == $user->password) {
            return $user;
        }
        foreach (['facebook_token', 'gplus_token', 'twitter_token'] as $token)
            if (isset($request[$token]) && ($request[$token] == $user->getAttribute($token))) {
                // social login attempt successful
                return $user;
            }
    }
}