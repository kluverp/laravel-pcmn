<?php

namespace Kluverp\Pcmn\Auth;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Requests\LoginRequest;
use Kluverp\Pcmn\Models\User;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class LoginController extends Controller
{
    /**
     * Load login page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pcmn::login.index');
    }

    /**
     * Handle the form submit.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function post(LoginRequest $request)
    {
        // check if we can find the user
        if ($user = User::authenticate($request->email, $request->password)) {

            // update the user record and set session
            $user->login();

            // redirect user to dashboard
            return redirect()->route('pcmn.dashboard');
        }

        return redirect()->to(route('pcmn.login'))->withAlertDanger(__('pcmn::login.alerts.failure'));
    }

    /**
     * Logs out the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // forget the session data
        session()->forget('pcmn');

        // go to login screen
        return redirect()->to('pcmn.login');
    }
}