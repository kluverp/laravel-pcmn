<?php

namespace Kluverp\Pcmn\Auth;

use Kluverp\Pcmn\BaseController;
use Kluverp\Pcmn\Notifications\ForgotPassword;
use Kluverp\Pcmn\Requests\ForgottenRequest;
use Kluverp\Pcmn\Models\User;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class ForgottenController extends BaseController
{
    /**
     * The view/trans/route namespace.
     *
     * @var string
     */
    protected $namespace = 'auth';

    /**
     * Show the Forgotten Password page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->viewNamespace('forgotten'), [
            'transNamespace' => $this->transNamespace()
        ]);
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
            return redirect()->back()->withAlertInfo(__($this->transNamespace('alerts.no_such_user')));
        }

        // genereate a random token
        $token = str_random(255);

        // store token with user record
        $user->reset_token = $token;
        $user->save();

        // notify user
        $user->notify(new ForgotPassword($token));

        return redirect()->back()->withAlertSuccess(__($this->transNamespace('alerts.reset_email_send')));
    }
}