<?php

namespace Kluverp\Pcmn\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hash;

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
        if (Hash::check($password, $user->password)) {
            return $user;
        }

        return false;
    }

    /**
     * Update the user record after successful login.
     *
     * @return $this
     */
    public function login()
    {
        $this->last_visit = date('Y-m-d H:i:s');
        $this->remember_token = str_random(100);
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
        return config('pcmn.table_prefix') . 'user';
    }
}
