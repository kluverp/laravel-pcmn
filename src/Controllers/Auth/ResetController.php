<?php

namespace Kluverp\Pcmn\Auth;

use Kluverp\Pcmn\BaseController;
use Kluverp\Pcmn\Requests\ResetRequest;
use Kluverp\Pcmn\Models\User;

/**
 * Class ResetController
 * @package Kluverp\Pcmn\Auth
 */
class ResetController extends BaseController
{
    /**
     * The view/trans/route namespace.
     *
     * @var string
     */
    protected $namespace = 'auth';

    /**
     * Loads the Password reset form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->transNamespace('reset'), [
            'token' => request()->route('token'),
            'transNamespace' => $this->transNamespace(),
            'routeNamespace' => $this->routeNamespace(false, true)
        ]);
    }

    /**
     * @return mixed
     */
    public function post(ResetRequest $request)
    {
        $user = User::where('active', 1)
            ->where('email', $request->get('email'))
            ->where('reset_token', $request->route('token'))
            ->first();

        // if the user cannot be located, return with message
        if (!$user) {
            return redirect()->back()->withAlertDanger(__($this->transNamespace('alerts.reset_failure')));
        }

        // update the user record
        $user->password = bcrypt($request->get('password'));
        $user->reset_token = null;
        $user->save();

        return redirect()->route($this->routeNamespace('login'))->withAlertSuccess(__($this->transNamespace('alerts.reset_success')));
    }
}
