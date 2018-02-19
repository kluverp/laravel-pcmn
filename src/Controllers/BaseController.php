<?php

namespace Kluverp\Pcmn;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Lib\Breadcrumb;
use Kluverp\Pcmn\Lib\Menu;
use View;

/**
 * Class BaseController
 * @package Kluverp\Pcmn
 */
class BaseController extends Controller
{
    /**
     * Controller specific namespace.
     *
     * @var string
     */
    protected $namespace = '';
    /**
     * The route namespace.
     *
     * @var string
     */
    protected $routeNamespace = 'pcmn.';

    /**
     * The view namespace.
     *
     * @var string
     */
    protected $viewNamespace = 'pcmn::';

    /**
     * The translations namespace.
     *
     * @var string
     */
    protected $transNamespace = 'pcmn::';

    /**
     * The breadcrumbs object.
     *
     * @var
     */
    protected $breadcrumbs;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        // load the menu
        View::share('menu', (new Menu(config('pcmn.menu'), config('pcmn.tables')))->getMenu());

        // init new object
        $this->breadcrumbs = new Breadcrumb();
    }

    /**
     * Returns the route namespace. When flag root == true, the namespace is given from root.
     *
     * @param string $str
     * @param bool $root
     * @return string
     */
    protected function routeNamespace($str = '', $root = false)
    {
        // from root if you please
        if ($root) {
            return $this->routeNamespace . ltrim($str, '.');
        }

        return $this->routeNamespace . $this->namespace . '.' . ltrim($str, '.');
    }

    /**
     * Returns the path to the view namespace.
     *
     * @param $str
     * @return string
     */
    protected function viewNamespace($str)
    {
        return $this->viewNamespace . $this->namespace . '.' . ltrim($str, '.');
    }

    /**
     * Returns the translations namespace.
     *
     * @param string $str
     * @return string
     */
    protected function transNamespace($str = '')
    {
        return $this->transNamespace . $this->namespace . '.' . ltrim($str, '.');
    }
}