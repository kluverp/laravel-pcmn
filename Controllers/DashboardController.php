<?php

namespace Kluverp\Pcmn;

use Illuminate\Routing\Controller;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Load dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pcmn::dashboard');
    }
}