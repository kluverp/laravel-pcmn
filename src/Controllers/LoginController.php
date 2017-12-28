<?php

namespace Kluverp\Pcmn;

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
        if ($user = User::authenticate($request->email, bcrypt($request->password))) {

            // update the user record
            $user->login();

            // put generated token in session
            session()->put('pcmn.auth_token', $user->auth_token);
        }

        return redirect()->to(route('pcmn.login'))->withAlertDanger(__('pcmn::login.alerts.failure'));
    }
}