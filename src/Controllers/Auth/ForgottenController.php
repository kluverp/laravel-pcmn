<?php

namespace Kluverp\Pcmn\Auth;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Notifications\ForgotPassword;
use Kluverp\Pcmn\Requests\ForgottenRequest;
use Kluverp\Pcmn\Models\User;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class ForgottenController extends Controller
{
    /**
     * Show the Forgotten Password page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pcmn::login.forgotten');
    }

    /**
     * Handle the password forgotten form post by sending the user a Notification.
     *
     * @param ForgottenRequest $request
     * @return mixed
     */
    public function post(ForgottenRequest $request)
    {
        // check if the users exists, if not we return and inform the user there is no such user.
        // possible security risk, but debatable.
        if (!$user = User::byEmail($request->email)) {
            return redirect()->back()->withAlertInfo('No such user');
        }

        // genereate a random token
        $token = str_random(255);

        // store token with user record
        $user->reset_token = $token;
        $user->save();

        // notify user
        $user->notify(new ForgotPassword($token));

        return redirect()->back()->withAlertSuccess('Send!');
    }
}