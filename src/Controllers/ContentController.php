<?php

namespace Kluverp\Pcmn;

use Kluverp\Pcmn\Lib\DataTable;
use Kluverp\Pcmn\Lib\TableConfig;
use Kluverp\Pcmn\Lib\Form\Form;

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

    protected $table = null;
    protected $config = null;

    /**
     * ContentController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // set the table parameter
        $this->table = request()->route('table');

        // create new TableConfig object
        $this->config = new TableConfig($this->table, config('pcmn.tables.' . $this->table));
    }

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

    public function edit($table, $id)
    {
        return view($this->viewNamespace('edit'), [
            'title' => $this->config->getTitle('singular'),
            'description' => $this->config->getDescription(),
            'form' => (new Form($this->config))
        ]);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}