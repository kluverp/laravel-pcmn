<?php

namespace Kluverp\Pcmn;

/**
 * Class ContentController
 * @package Kluverp\Pcmn
 */
class ContentController extends BaseController
{
    /**
     * Load content index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->viewNamespace('dashboard'));
    }
}