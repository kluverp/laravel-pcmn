<?php

namespace Kluverp\Pcmn;

use Kluverp\Pcmn\Lib\DataTable;
use Kluverp\Pcmn\Lib\TableConfig;

/**
 * Class ContentController
 * @package Kluverp\Pcmn
 */
class ContentController extends BaseController
{
    /**
     * The view/trans/route namespace.
     *
     * @var string
     */
    protected $namespace = 'content';

    /**
     * Load content index.
     *
     * @param $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($table)
    {
        // create new TableConfig object
        $config = new TableConfig($table, config('pcmn.tables.' . $table));

        // init new DataTable processor
        $dataTable = new DataTable($config);

        return view($this->viewNamespace('index'), [
            'title' => $config->getTitle(),
            'description' => $config->getDescription(),
            'dataTable' => $dataTable
        ]);
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}