<?php

namespace Kluverp\Pcmn\Auth;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Requests\ResetRequest;
use Kluverp\Pcmn\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class ResetController extends Controller
{
    /**
     * Loads the Password reset form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pcmn::login.reset', [
            'token' => request()->route('token')
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
            return redirect()->back()->withAlertDanger(__('pcmn::login.alerts.reset_failure'));
        }

        // update the user record
        $user->password = bcrypt($request->get('password'));
        $user->reset_token = null;
        $user->save();

        return redirect()->route('pcmn.login')->withAlertSuccess(__('pcmn::login.alerts.reset_success'));
    }
}
