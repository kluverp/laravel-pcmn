<?php

namespace Kluverp\Pcmn;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Notifications\ForgotPassword;
use Kluverp\Pcmn\Requests\LoginRequest;
use Kluverp\Pcmn\Requests\ForgottenRequest;
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
        if ($user = User::authenticate($request->email, bcrypt($request->password))) {

            // update the user record
            $user->login();

            // put generated token in session
            session()->put('pcmn.auth_token', $user->auth_token);

            // regenerate the session ID
            session()->regenerate();
        }

        return redirect()->to(route('pcmn.login'))->withAlertDanger(__('pcmn::login.alerts.failure'));
    }

    /**
     * Show the Forgotten Password page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgotten()
    {
        return view('pcmn::login.forgotten');
    }

    /**
     * Handle the password forgotten form post by sending the user a Notification.
     *
     * @param ForgottenRequest $request
     * @return mixed
     */
    public function postForgotten(ForgottenRequest $request)
    {
        // check if the users exists, if not we return and inform the user there is no such user.
        // possible security risk, but debatable.
        if (!$user = User::byEmail($request->email)) {
            return redirect()->back()->withAlertInfo('No such user');
        }

        // notify user
        $user->notify(new ForgotPassword());

        return redirect()->back()->withAlertSuccess('Send!');
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