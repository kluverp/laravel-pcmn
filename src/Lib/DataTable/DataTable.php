<?php

namespace Kluverp\Pcmn\Lib\DataTable;

use DB;
use Kluverp\Pcmn\Lib\Model;

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

    /**
     * Datatable namespaces.
     *
     * @var string
     */
    private $transNs = 'pcmn::datatable';
    private $routeNs = 'pcmn.datatable';
    private $viewNs = 'pcmn::datatable';

    /**
     * Parent record model.
     *
     * @var Model|null
     */
    private $model = null;

    /**
     * DataTable constructor.
     *
     * @param $config
     * @param array $parameters
     */
    public function __construct($config, $parameters = [], Model $model = null)
    {
        // set properties
        $this->config = $config;

        // set datatable ajax parameters
        $this->parameters = $parameters;

        // set model
        $this->model = $model;
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
            'model' => $this->model,
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
                $columns[] = '&lt;' . $index . '&gt;';
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
                'draw' => (int)$this->parameter('draw'),
                'error' => $error = $e->getMessage()
            ];
        }

        foreach ($collection as &$row) {
            $row = new DataTableRow($row, $this->config);
        }

        // form data array
        $data = [
            'draw' => (int)$this->parameter('draw'),
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
        $cols = $this->query_cols();

        $query = DB::table($this->config->getTable())
            ->select($cols)
            ->skip($this->parameter('start'))
            ->take($this->parameter('length'));

        // handle search
        $this->query_search($query, $cols);

        // only load the children if parent given
        $this->query_xref($query);

        // order clause
        $this->query_order($query, $cols);

        return $query->get();
    }

    /**
     * Returns the datatable title.
     *
     * @return mixed
     */
    public function title()
    {
        return $this->config->getTitle();
    }

    /**
     * Returns a datatable parameter.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    private function parameter($key, $default = null)
    {
        return array_get($this->parameters, $key, $default);
    }

    /**
     * Handle the search query.
     *
     * @param $query
     * @param $cols
     */
    private function query_search($query, $cols)
    {
        if ($str = $this->parameter('search.value')) {
            $query->where(function ($query) use ($cols, $str) {
                foreach ($cols as $col) {
                    $query->orWhere($col, 'like', '%' . $str . '%');
                }
            });
        }

        return $query;
    }

    /**
     * Returns the columns to retrieve.
     *
     * @return array
     */
    private function query_cols()
    {
        // always include 'id' column, we need it for the rows
        $cols = ['id'];

        return $cols = array_merge($cols, array_keys($this->config->getIndex()));
    }

    /**
     * Returns the ID's to get if the record has a parent model.
     *
     * @param $query
     * @return mixed
     */
    private function query_xref($query)
    {
        // if this is a child record, find the id's to load
        if ($model = $this->model) {
            if ($ids = $model->childIds($this->config->getTable())) {
                $query->whereIn('id', $ids);
            }
        }

        return $query;
    }

    /**
     * The ordering.
     *
     * @param $query
     * @param $cols
     * @return mixed
     */
    private function query_order($query, $cols)
    {
        return $query->orderBy($cols[$this->parameter('order.0.column')], $this->parameter('order.0.dir'));
    }
}