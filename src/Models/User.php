<?php

namespace Kluverp\Pcmn\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'auth_token', 'auth_token_expiration', 'last_visit',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Returns the user record by session token.
     *
     * @param $token
     * @return mixed
     */
    public static function bySession($token)
    {
        return self::where('auth_token', $token)
            ->where('auth_token_expiration', '<', time())
            ->first();
    }

    /**
     * Authenticate the user bases on username and password combination.
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    public static function authenticate($username, $password)
    {
        return self::where('email', $username)
            ->where('password', $password)
            ->first();
    }

    /**
     * Update the user record after successful login.
     *
     * @param $authToken
     */
    public function updateLogin($authToken)
    {
        $this->last_visit = date();
        $this->auth_token = $authToken;
        $this->save();
    }
}
