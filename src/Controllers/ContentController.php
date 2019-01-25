<?php

namespace Kluverp\Pcmn;

use Kluverp\Pcmn\Models\BaseModel;
use Kluverp\Pcmn\Lib\DataTable\DataTable;
use Kluverp\Pcmn\Lib\TableConfig;
use Kluverp\Pcmn\Lib\Form\Form;
use Kluverp\Pcmn\Lib\Model;
use Illuminate\Http\Request;
use Kluverp\Pcmn\Lib\Xref;

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
    protected $transNs = 'pcmn::content';
    protected $routeNs = 'pcmn.content';
    protected $viewNs = 'pcmn::content';

    /**
     * Table configuration object.
     *
     * @var TableConfig|null
     */
    protected $table = null;
    protected $tableName = null;

    /**
     * Model instance.
     *
     * @var Model|null
     */
    protected $model = null;

    /**
     * ContentController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->tableName = request()->route('table');

        // create new TableConfig object
        $this->table = $this->tableConfigRepo->find($this->tableName);

        // create new model
        $this->model = new Model($this->tableName);
    }

    /**
     * Load content index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view($this->viewNs . '.index', [
            'title' => $this->table->getTitle(),
            'description' => $this->table->getDescription(),
            'dataTable' => new DataTable($this->table),
            'breadcrumbs' => $this->breadcrumbs,
            'transNs' => $this->transNs
        ]);
    }

    /**
     * Create new record.
     *
     * @param $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($table, $parentId = null, $parentTable = null, Xref $xrefs)
    {
        // create new form
        $form = new Form($this->table, $this->model, [
            'method' => 'post',
            'action' => route('pcmn.content.store', [$table, $parentId, $parentTable])
        ]);

        return view($this->viewNs . '.create', [
            'transNs' => $this->transNs,
            'routeNs' => $this->routeNs,
            'config' => $this->table,
            'title' => $this->table->getTitle('singular'),
            'description' => $this->table->getDescription(),
            'form' => $form,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    /**
     * Store a new record.
     *
     * @param $table
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($table, $parentId = null, $parentTable = null, Request $request)
    {
        // create form
        $form = new Form($this->table, null, [
            'request' => $request
        ]);

        // validate the form
        $form->getValidator()->validate();

        // create a new record
        $recordId = $this->model->create($form->getForStorage(), $parentTable, $parentId);

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
    public function edit($table, $id, Xref $xrefs)
    {
        // show 404 page, in case model is not found
        $model = $this->model->find($id);

        // create form
        $form = new Form($this->table, $model, [
            'method' => 'put',
            'action' => route($this->routeNs . '.update', [$table, $id])
        ]);

        // create breadcrumbs
        $this->breadcrumbs($model);

        return view($this->viewNs . '.edit', [
            'transNs' => $this->transNs,
            'routeNs' => $this->routeNs,
            'config' => $this->table,
            'model' => $this->model,
            'title' => $this->table->getTitle('singular'),
            'description' => $this->table->getDescription(),
            'form' => $form,
            'breadcrumbs' => $this->breadcrumbs,
            'datatables' => $xrefs->datatables($this->table, $model)
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
    public function update($table, $id, $parentTable = null, $parentId = null, Request $request)
    {
        // get the model instance
        if (!$model = $this->model->find($id)) {
            return abort();
        }

        // create new form instance
        $form = new Form($this->table, $model, [
            'method' => 'put',
            'action' => route($this->routeNs . '.update', [$table, $id]),
            'request' => $request,
        ]);

        // validate the form
        $form->getValidator()->validate();

        // update model
        $model->update($form->getForStorage(), $parentTable, $parentId);

        return redirect()
            ->back()
            ->with('alert_success', __($this->transNs . '.alerts.updated'));
    }

    /**
     * Delete the given record.
     *
     * @param $table
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($table, $id, Request $request)
    {
        // remove the record
        $this->model->delete($id);

        if ($request->ajax()) {
            return response()->json(['ok']);
        }

        return redirect()
            ->route($this->routeNs . '.index', [$table])
            ->with('alert_danger', __($this->transNs . '.alerts.destroyed'));
    }
}