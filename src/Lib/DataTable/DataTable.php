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
    private $config = null;

    /**
     * The DataTable parameters.
     *
     * @var array
     */
    private $parameters = [];

    private $transNs = 'pcmn::datatable';
    private $routeNs = 'pcmn.datatable';
    private $viewNs = 'pcmn::datatable';

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
        return view($this->viewNs . '.table', [
            'thead' => $this->getTableHead(),
            'config' => $this->config,
            'transNs' => $this->transNs,
            'routeNs' => $this->routeNs,
            'data' => $this->data()
        ])->render();
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
                $columns[] = '&lt;'. $index .'&gt;';
            }
        }

        return $columns;
    }

    /**
     * Outputs the JavaScript part for use in View.
     *
     * @return string
     */
    public function data()
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

        return $data;
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

        return DB::table($this->config->getTable())
            ->select($cols)
            ->skip($this->parameters['start'])
            ->take($this->parameters['length'])
            ->orderBy($cols[$this->parameters['order'][0]['column']], $this->parameters['order'][0]['dir'])
            ->get();
    }

    public function title()
    {
        return $this->config->getTitle();
    }
}