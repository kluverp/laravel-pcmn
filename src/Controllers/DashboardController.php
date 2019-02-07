<?php

namespace Kluverp\Pcmn;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends BaseController
{
    /**
     * Load dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->viewNs . '.dashboard', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}