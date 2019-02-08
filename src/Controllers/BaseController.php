<?php

namespace Kluverp\Pcmn;

use Illuminate\Routing\Controller;
use Kluverp\Pcmn\Lib\Breadcrumb;
use Kluverp\Pcmn\Lib\Navigation;
use Kluverp\Pcmn\Lib\TableConfig\TableConfigRepository;
use Kluverp\Pcmn\Lib\Model;

/**
 * Class BaseController
 * @package Kluverp\Pcmn
 */
class BaseController extends Controller
{
    /**
     * The route namespace.
     *
     * @var string
     */
    protected $routeNs = 'pcmn.';

    /**
     * The view namespace.
     *
     * @var string
     */
    protected $viewNs = 'pcmn::';

    /**
     * The translations namespace.
     *
     * @var string
     */
    protected $transNs = 'pcmn::';

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
        view()->share('menu', (new Navigation(config('pcmn.menu'), $this->tableConfigRepo))->getMenu());
        view()->share('viewNs', $this->viewNs);
        view()->share('routeNs', $this->routeNs);
        view()->share('transNs', $this->transNs);

        // init new object
        $this->breadcrumbs = new Breadcrumb();

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