<?php

namespace Kluverp\Pcmn;

use Kluverp\Pcmn\Lib\DataTable;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($table)
    {
        // init new DataTable processor
        $dataTable = new DataTable(config('pcmn.tables.' . $table));

        return view($this->viewNamespace('index'), [
            'title' => 'foobar',
            'description' => 'foobarioriaosdfjafl',
            'dataTable' => $dataTable
        ]);
    }
}