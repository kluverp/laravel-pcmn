<?php

namespace Kluverp\Pcmn\Lib;

class Breadcrumb
{
    /**
     * The breadcrumbs array.
     *
     * @var array
     */
    private $crumbs = [];

    /**
     * The view location.
     *
     * @var string
     */
    private $view = 'pcmn::_components.breadcrumbs';

    /**
     * Breadcrumb constructor.
     */
    public function __construct()
    {
        // add the home route
        $this->add(route('pcmn.dashboard'), 'Dashboard');
    }

    /**
     * Returns Breadcrumbs HTML.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function html()
    {
        return view($this->view, $this->getBreadCrumbs());
    }

    /**
     * Returns the array with crumbs.
     *
     * @return array
     */
    public function getBreadCrumbs()
    {
        return $this->crumbs;
    }

    /**
     * Add a breadcrumb to our crumbs array.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    private function add($key, $value)
    {
        return $this->crumbs[$key] = $value;
    }
}