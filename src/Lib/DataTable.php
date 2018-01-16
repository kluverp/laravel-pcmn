<?php

namespace Kluverp\Pcmn\Lib;

use DB;

class DataTable
{
    /**
     * Source table name.
     *
     * @var string
     */
    private $config = '';

    /**
     * The DataTable parameters.
     *
     * @var array
     */
    private $parameters = [];

    /**
     * DataTable constructor.
     *
     * @param $config
     * @param array $parameters
     */
    public function __construct($config, $parameters = [])
    {
        // set properties
        $this->config = $config;

        // set datatable ajax parameters
        $this->parameters = $parameters;
    }

    /**
     * Outputs the HTML part for use in View.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function html()
    {
        return view('pcmn::datatable.table', [
            'thead' => $this->getTableHead()
        ]);
    }

    /**
     * Returns array with <thead> items.
     *
     * @return array
     */
    public function getTableHead()
    {
        $columns = [];

        // loop over the configuration, to set each label
        foreach ($this->config->getIndex() as $index => $options) {
            if ($field = $this->config->getField($index, 'label')) {
                $columns[$index] = $field;
            } else {
                $columns[] = '';
            }
        }

        // add the create button if permissions allow it
        if ($createBtn = $this->getCreateBtn()) {
            $columns[] = '<div class="text-right">' . $createBtn . '</div>';
        }

        return $columns;
    }

    /**
     * Outputs the JavaScript part for use in View.
     *
     * @return string
     */
    public function script()
    {
        $data = [];
        foreach ($this->config->getIndex() as $i) {
            $data[]["data"] = $i;
        }

        // row actions
        $data[]["data"] = [
            'name' => 'actions',
            'searchable' => false,
            'sortable' => false
        ];

        return sprintf('
        $("#table").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "%s",
            "language": {
                "url": "%s"
            },
            "columns": %s
        });', route("pcmn.datatable.index", $this->getTable()), config('pcmn.datatable.languageUrl'), json_encode($data));
    }

    /**
     * Process AJAX request from client.
     *
     * @return array
     */
    public function ajax()
    {
        try {
            $query = $this->query();
        } catch (\Exception $e) {
            return [
                'draw' => (int)$this->parameters['draw'],
                'error' => $error = $e->getMessage()
            ];
        }

        foreach ($query as &$q) {
            $q->actions = $this->getActions(1);
        }

        // form data array
        $data = [
            'draw' => (int)$this->parameters['draw'],
            'recordsTotal' => $query->count(),
            'recordsFiltered' => $query->count(),
            'data' => $query->toArray(),
        ];

        return $data;
    }

    /**
     * Returns the "Action" buttons for each row.
     *
     * @param $rowId
     * @return string
     */
    private function getActions($rowId)
    {
        $buttons = '';
        $buttons .= ' ' . $this->getReadBtn($rowId);
        $buttons .= ' ' . $this->getUpdateBtn($rowId);
        $buttons .= ' ' . $this->getDeleteBtn($rowId);

        return '<div class="text-right">' . $buttons . '</div>';
    }

    /**
     * Perform the database query.
     *
     * @return mixed
     */
    private function query()
    {
        return DB::table($this->getTable())
            ->select($this->config->getIndex())
            ->skip($this->parameters['start'])
            ->take($this->parameters['length'])
            ->orderBy($this->parameters['columns'][$this->parameters['order'][0]['column']]['data'], $this->parameters['order'][0]['dir'])
            ->get();
    }

    /**
     * Returns the create button if user is allowed to create new records.
     *
     * @return string
     */
    private function getCreateBtn()
    {
        // if user has permission to create new records
        if ($this->config->canCreate()) {
            return '
            <a href="' . $this->route('create') . '" class="btn btn-success btn-sm">
                ' . self::trans('actions.create') . '
            </a>';
        }

        return false;
    }

    /**
     * Returns the row delete button.
     *
     * @param $rowId
     * @return string
     */
    private function getDeleteBtn($rowId)
    {
        if ($this->config->canDelete()) {
            return '
            <a class="btn btn-danger btn-sm" href="#">
                ' . self::trans('actions.delete') . '
            </a>';
        }

        return false;
    }

    /**
     * @param $rowId
     * @return bool|string
     */
    private function getUpdateBtn($rowId)
    {
        if ($this->config->canUpdate()) {
            return '
            <a class="btn btn-primary btn-sm" href="' . $this->route('edit', $rowId) . '">
                ' . self::trans('actions.edit') . '
            </a>';
        }

        return false;
    }

    /**
     * @param $rowId
     * @return bool|string
     */
    private function getReadBtn($rowId)
    {
        if ($this->config->canRead()) {
            return '
            <a class="btn btn-default btn-sm" href="' . $this->route('show', $rowId) . '">
                ' . self::trans('actions.read') . '
            </a>';
        }

        return false;
    }

    /**
     * Returns the table name to build the table for.
     *
     * @return mixed
     */
    private function getTable()
    {
        return $this->config->getTable();
    }


    /**
     * Returns a DataTable translation text for given key.
     *
     * @param $key
     * @return array|null|string
     */
    private static function trans($key)
    {
        return __('pcmn::datatable.' . $key);
    }

    /**
     * Returns content route.
     *
     * @param $route
     * @param array $params
     * @return string
     */
    private function route($route, $params = [])
    {
        $params = array_merge([$this->getTable()], $params);

        return route('pcmn.content.' . $route, $params);
    }
}