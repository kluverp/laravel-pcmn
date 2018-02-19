<?php

namespace Kluverp\Pcmn;

use Kluverp\Pcmn\Lib\DataTable;
use Kluverp\Pcmn\Lib\TableConfig;
use Kluverp\Pcmn\Lib\Form\Form;
use DB;
use Illuminate\Http\Request;
use Kluverp\Pcmn\Lib\Form\DataHandler;
use Kluverp\Pcmn\Lib\Breadcrumb;

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
        $this->config = new TableConfig($this->table, config('pcmn.tables.' . $this->table), request()->route('id'));

        // add index url
        $this->breadcrumbs->add($this->config->getIndexUrl(), $this->config->getTitle('plural'));
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
            'dataTable' => $dataTable,
            'breadcrumbs' => $this->breadcrumbs
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
     *
     * @param $table
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($table, Request $request)
    {
        // init data handler object
        $dataHandler = new DataHandler($this->config, $request->except(['_token', '_method']));

        // insert new record
        DB::table($table)->insert($dataHandler->getForStorage());

        // get last insert ID
        $id = DB::getPdo()->lastInsertId();

        // retur to the edit screen
        return redirect()
            ->route('pcmn.content.edit', [$table, $id])
            ->with('alert_success', 'Opgelsagen!');
    }

    /**
     * Show a read-only version of the data.
     *
     */
    public function show()
    {

    }

    public function edit($table, $id)
    {
        // if record cannot be found, show a 404 page
        if (!$data = DB::table($table)->find($id)) {
            abort(404);
        }

        // create new form object
        $form = new Form($this->config, [
            'method' => 'post',
            'action' => route('pcmn.content.update', [$table, $id]),
            'data' => $data
        ]);

        // add breadcrumb
        $this->breadcrumbs->add('', $this->config->getTitle('singular') . ' ('. request()->route('id') .')');

        return view($this->viewNamespace('edit'), [
            'title' => $this->config->getTitle('singular'),
            'description' => $this->config->getDescription(),
            'form' => $form,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Update the record.
     *
     * @param $table
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($table, $id, Request $request)
    {
        // check if record exists
        if (!$row = DB::table($table)->find($id)) {
            abort(404);
        }

        $form = new Form($this->config, [
            'method' => 'post',
            'action' => route('pcmn.content.update', [$table, $id]),
            'request' => $request
        ]);

        if (!$form->validate()) {
            // return with messages
        }

        // init data handler
        $dataHandler = new DataHandler($this->config, $request->except(['_token', '_method']));

        // update model
        DB::table($table)->where('id', $id)->update($dataHandler->getForStorage());

        return redirect()
            ->back()
            ->with('alert_success', 'Opgelsagen!');
    }

    /**
     * Delete the given record.
     *
     * @param $table
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($table, $id)
    {
        // remove the record
        DB::table($table)->where('id', $id)->delete();

        return redirect()
            ->route('pcmn.content.index', [$table])
            ->with('alert_danger', 'Verwijderd!');
    }
}