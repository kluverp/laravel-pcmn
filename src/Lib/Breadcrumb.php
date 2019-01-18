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
     * @param array $crumbs
     */
    public function __construct($crumbs = [])
    {
        // add the home route
        $this->add(route('pcmn.dashboard'), 'Dashboard');

        // fill if crumbs are given
        foreach ($crumbs as $key => $value) {
            $this->add($key, $value);
        }
    }

    /**
     * Returns Breadcrumbs HTML.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function html()
    {
        return view($this->view, ['breadcrumbs' => $this->getBreadCrumbs()]);
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
    public function add($url, $label)
    {
        return $this->crumbs[$url] = $label;
    }

    public function adda(array $crumbs)
    {
        foreach($crumbs as $url => $label)
        {
            $this->add($url, $label);
        }
    }


}