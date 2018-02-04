<?php

namespace Kluverp\Pcmn;

use Kluverp\Pcmn\Lib\DataTable;
use Kluverp\Pcmn\Lib\TableConfig;
use Kluverp\Pcmn\Lib\Form\Form;
use DB;
use Illuminate\Http\Request;

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
     * Table to view.
     *
     * @var \Illuminate\Routing\Route|null|object|string
     */
    protected $table = null;

    /**
     * Table configuration object.
     *
     * @var TableConfig|null
     */
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

    /**
     * Create new record.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view($this->viewNamespace('create'), [
            'title' => $this->config->getTitle('singular'),
            'description' => $this->config->getDescription(),
            'form' => (new Form($this->config, null, route('pcmn.content.store', [$this->table])))
        ]);
    }

    /**
     * Store a new record.
     */
    public function store($table, Request $request)
    {
        // insert new record
        $record = DB::table($table)->insert($request->except(['_token']));

        // get last insert ID
        $id = DB::getPdo()->lastInsertId();

        // retur to the edit screen
        return redirect()
            ->route('pcmn.content.edit', [$table, $id])
            ->with('alert_success', 'Opgelsagen!');
    }

    public function show()
    {

    }

    public function edit($table, $id)
    {
        if (!$data = DB::table($table)->find($id)) {
            abort(404);
        }

        return view($this->viewNamespace('edit'), [
            'title' => $this->config->getTitle('singular'),
            'description' => $this->config->getDescription(),
            'form' => (new Form($this->config, $data, route('pcmn.content.update', [$table, $id])))
        ]);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}