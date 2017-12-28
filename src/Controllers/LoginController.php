<?php

namespace Kluverp\Pcmn;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Requests\LoginRequest;

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
     */
    public function post(LoginRequest $request)
    {

    }
}