<?php

namespace Kluverp\Pcmn\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hash;
use Illuminate\Support\Facades\Cookie;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'auth_token',
        'auth_token_expiration',
        'last_visit',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Returns the user record by session token.
     *
     * @return mixed
     */
    public static function bySession()
    {
        return self::where('id', session()->get('pcmn.user_id'))->first();
    }

    /**
     * Returns a user by email address.
     *
     * @param $email
     * @return mixed
     */
    public static function byEmail($email)
    {
        return self::where('email', $email)->first();
    }

    /**
     * Return a user with use of remember_token value.
     *
     * @param $token
     * @return mixed
     */
    public static function byToken($token)
    {
        return self::where('remember_token', $token)->first();
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
        $user = self::where('email', $username)
            ->where('active', 1)
            ->first();

        // check the password
        if (!empty($user) && Hash::check($password, $user->password)) {
            return $user;
        }

        return false;
    }

    /**
     * Update the user record after successful login.
     *
     * @return $this
     */
    public function login($rememberMe = false)
    {
        $this->last_visit = date('Y-m-d H:i:s');
        if ($rememberMe) {
            $this->remember_token = str_random(100);
            Cookie::queue('remember_token', $this->remember_token, 60 * 24 * 365);
        } else {
            $this->remember_token = null;
        }

        $this->save();

        // put generated token in session
        session()->put('pcmn.user_id', $this->id);

        // regenerate the session ID
        session()->regenerate();

        return $this;
    }

    /**
     * Returns the table name with custom prefix.
     *
     * @return string
     */
    public function getTable()
    {
        return config('pcmn.config.table_prefix') . 'user';
    }
}
