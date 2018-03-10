<?php

namespace Kluverp\Pcmn\Lib\DataTable;

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
     * Returns the title.
     *
     * @return mixed
     */
    public function title()
    {
        return $this->config->getTitle();
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
        foreach ($this->config->getIndex() as $key => $value) {
            $data[] = [
                'name' => $key,
                'data' => $key
            ];
        }

        // row actions
        $data[] = [
            'data' => 'actions',
            'name' => 'actions',
            'searchable' => false,
            'sortable' => false
        ];

        // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "pageLength": 50,

        return sprintf('
        $("#table").DataTable({
            "processing": true,
            "serverSide": true,            
            "paging": true,
            "ajax": "%s",
            "language": {
                "url": "%s"
            },
            "columns": %s
        });', route("pcmn.datatable.index", $this->getTable()), config('pcmn.datatable.languageUrl'),
            json_encode($data));
    }

    /**
     * Process AJAX request from client.
     *
     * @return array
     */
    public function ajax()
    {
        try {
            $collection = $this->query();
        } catch (\Exception $e) {
            return [
                'draw' => (int)$this->parameters['draw'],
                'error' => $error = $e->getMessage()
            ];
        }

        foreach ($collection as &$row) {
            $row = new DataTableRow($row, $this->config);
        }

        // form data array
        $data = [
            'draw' => (int)$this->parameters['draw'],
            'recordsTotal' => $collection->count(),
            'recordsFiltered' => $collection->count(),
            'data' => $collection->toArray(),
        ];

        return $data;
    }

    /**
     * Perform the database query.
     *
     * @return mixed
     */
    private function query()
    {
        $cols = ['id'];
        $cols = array_merge($cols, array_keys($this->config->getIndex()));

        return DB::table($this->getTable())
            ->select($cols)
            ->skip($this->parameters['start'])
            ->take($this->parameters['length'])
            ->orderBy($cols[$this->parameters['order'][0]['column']], $this->parameters['order'][0]['dir'])
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
            <a href="' . $this->route('create', [$this->getTable()]) . '" class="btn btn-success btn-sm">
                ' . self::trans('actions.create') . '
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
    public static function trans($key)
    {
        return __('pcmn::datatable.' . $key);
    }

    /**
     * Returns content route.
     *
     * @param $route
     * @param array $parameters
     * @return string
     */
    public static function route($route, $parameters = [])
    {
        return route('pcmn.content.' . $route, $parameters);
    }
}