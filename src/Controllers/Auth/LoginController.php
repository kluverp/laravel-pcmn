<?php

namespace Kluverp\Pcmn\Auth;

use Kluverp\Pcmn\BaseController;
use Kluverp\Pcmn\Requests\LoginRequest;
use Kluverp\Pcmn\Models\User;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class LoginController extends BaseController
{
    /**
     * The view/trans/route namespace.
     *
     * @var string
     */
    protected $viewNs = 'pcmn::auth';
    protected $transNs = 'pcmn::auth';
    protected $routeNs = 'pcmn.auth';

    /**
     * Load login page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->viewNs . '.index');
    }

    /**
     * Handle the form submit.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(LoginRequest $request)
    {
        // check if we can find the user
        if ($user = User::authenticate($request->email, $request->password)) {

            // update the user record and set session
            $user->login($request->remember_me);

            // redirect user to dashboard
            return redirect()->route($this->routeNs . '.dashboard', true);
        }

        return redirect()
            ->to(route($this->routeNs . '.login'))
            ->withAlertDanger(__($this->transNs . '.alerts.failure'))
            ->withInput();
    }

    /**
     * Logs out the user by erasing the session data.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // forget the session data
        session()->forget('pcmn');

        // go to login screen
        return redirect()->route($this->routeNs . '.login');
    }
}