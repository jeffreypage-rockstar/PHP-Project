<?php namespace App\Dubb\Repos;

use App\Dubb\Exceptions\ApiException;
use App\Dubb\Exceptions\GenericException;
use App\Entities\Preferences;
use App\Entities\User;
use App\Dubb\Contracts\AuthInterface;
use App\Dubb\Contracts\Client;
use App\Http\Requests\SignIn;
use App\Http\Requests\SignUp;
use Illuminate\Support\Facades\Hash;

class EloquentAuthRepository implements AuthInterface
{

    protected $user;
    protected $preference;

    public function __construct(User $user, Preferences $preferences)
    {
        $this->user = $user;
        $this->preference = $preferences;
    }

    /**
     *  All Public Methods Next
     */


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

        if (isset($request['email']) && isset($request['username'])){
            $user = $this->user->where('email', $request['email'])
                ->with('preferences')->first();
        }


        if ($user) {
            // User already registered
            // So attempting to sign in the user.

            return $this->_loginAttempt($request, $user);
        }

        // create new user
        $request['password'] = bcrypt($request['password']);

        $user = User::create($request);

        $this->savePreferences($request, $user);

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

        $user = null;
        if(isset($request['email'])) {
            $user = $this->user->where('email', $request['email'])->first();
        }
        if(isset($request['username'])) {
            $user = $this->user->where('username', $request['username'])->first();
        }

        if ($user && Hash::check($request['password'], $user->password)) {

           return $user;
        }

        throw new GenericException('Authentication Failed');
    }

    /**
     * @param $request
     * @param $user
     */
    protected function savePreferences($request, $user)
    {
        if (isset($request['preferences'])) {
            foreach ($request['preferences'] as $pref) {
               $pref['user_id'] = $user->id;
               // delete if selected to delete
                if (isset($pref['delete']) && $pref['delete'] && isset($pref['id'])) {
                    $p = $this->preference->destroy($pref['id']);

                    if ($p > 0) {
                        continue;
                    }
                }
               $preference = isset($pref['id'])? $this->preference->find($pref['id']):null;
                if ($preference === null) {
                    // check if the same key exists for the user , if so retrieve that record.
                    $preference = $this->preference->where('user_id', $pref['user_id'])->where('key', $pref['key'])->first();
                }
               if ($preference !== null) {
                    foreach($pref as $key=>$val) {
                       $preference->setAttribute($key, $val);
                   }
                   $preference->save();
                   continue;
               }
               $this->preference->create($pref);
            }
        }
    }

    /**
     *  Private and Protected methods on bottom.
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
            $this->savePreferences($request, $user);
            return $user;
        }
        foreach (['facebook_token', 'gplus_token', 'twitter_token'] as $token) {

            // I have a token
            if (isset($request[$token]) && ($request[$token] == $user->getAttribute($token))) {
                // social login attempt successful
                $this->savePreferences($request, $user);
                return $user;
            }

            // I have a new token, update the token
            if (isset($request[$token]) && ($user->getAttribute($token) != '' || $user->getAttribute($token) == null)) {

                $user->setAttribute($token, $request[$token]);
                $user->save();
                $this->savePreferences($request, $user);
                return $user;
            }
        }

        throw new GenericException('Email/Username already registered.');
    }
}