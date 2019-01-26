<?php

namespace Kluverp\Pcmn;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Lib\Breadcrumb;
use Kluverp\Pcmn\Lib\Menu;
use Kluverp\Pcmn\Lib\TableConfig\TableConfigRepository;
use Kluverp\Pcmn\Lib\Model;

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
     * Table config container
     *
     * @var TableConfigRepository|null
     */
    protected $tableConfigRepo = null;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        // init table config repository (singleton in app container)
        $this->tableConfigRepo = app(TableConfigRepository::class);

        // load the menu
        view()->share('menu', (new Menu(config('pcmn.menu'), $this->tableConfigRepo))->getMenu());

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

    protected function trans($key)
    {
        return __($this->transNamespace($key));
    }

    /**
     * Build the breadcrumb trail for given model and it's parents.
     *
     * @param Model $model
     * @throws \Exception
     */
    protected function breadcrumbs(Model $model)
    {
        $crumbs = [];

        // get current model config
        $config = $this->tableConfigRepo->find($model->getTable());

        // rende last crumb
        $crumbs[''] = $config->getTitle('singular') . ($model->getId() > 0 ? ' (' . $model->getId() . ')' : '');

        $parent = $model->parent();
        while ($parent) {

            // get table config for this model
            $config = $this->tableConfigRepo->find($parent->getTable());

            // add the breadcrumb
            $crumbs[$config->getEditUrl($parent->id)] = $config->getTitle('singular') . ' (' . $parent->getId() . ')';

            // get next record
            $parent = $parent->parent();
        }

        // last one
        $crumbs[$config->getIndexUrl()] = $config->getTitle('plural');

        $this->breadcrumbs->adda(array_reverse($crumbs));
    }
}