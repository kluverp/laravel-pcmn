<?php

namespace Kluverp\Pcmn;

use Kluverp\Pcmn\Lib\DataTable;
use Kluverp\Pcmn\Lib\TableConfig;
use Kluverp\Pcmn\Lib\Form\Form;
use Kluverp\Pcmn\Lib\Model;
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
        return view($this->viewNamespace('index'), [
            'title' => $this->config->getTitle(),
            'description' => $this->config->getDescription(),
            'dataTable' => new DataTable($this->config),
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Create new record.
     *
     * @param $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($table)
    {
        // create new form
        $form = new Form($this->config, [
            'method' => 'post',
            'action' => route('pcmn.content.store', $table)
        ]);

        return view($this->viewNamespace('create'), [
            'title' => $this->config->getTitle('singular'),
            'description' => $this->config->getDescription(),
            'form' => $form,
            'breadcrumbs' => $this->breadcrumbs
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
        // create form
        $form = new Form($this->config, [
            'request' => $request
        ]);

        // validate the form
        if (!$form->validate()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        // create a new record
        $recordId = Model::create($table, $form->getForStorage());

        // return to the edit screen
        return redirect()
            ->route('pcmn.content.edit', [$table, $recordId])
            ->with('alert_success', 'Opgelsagen!');
    }

    /**
     * Show a read-only version of the data.
     *
     */
    public function show()
    {

    }

    /**
     * Edit an existing record.
     *
     * @param $table
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($table, $id)
    {
        // if record cannot be found, show a 404 page
        if (!$model = Model::read($table, $id)) {
            abort(404);
        }

        // create new form object
        $form = new Form($this->config, [
            'method' => 'put',
            'action' => route('pcmn.content.update', [$table, $id]),
            'data' => $model
        ]);

        // add breadcrumb
        $this->breadcrumbs->add('', $this->config->getTitle('singular') . ' (' . request()->route('id') . ')');

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
        if (!$model = Model::read($table, $id)) {
            abort(404);
        }

        // create new form instance
        $form = new Form($this->config, [
            'method' => 'put',
            'action' => route('pcmn.content.update', [$table, $id]),
            'request' => $request,
            'data' => $model
        ]);

        // validate the form
        if (!$form->validate()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        // update model
        Model::update($table, $id, $form->getForStorage());

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
        Model::delete($table, $id);

        return redirect()
            ->route('pcmn.content.index', [$table])
            ->with('alert_danger', 'Verwijderd!');
    }
}