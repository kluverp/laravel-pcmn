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
     */
    public function html()
    {
        return '
        <table id="table" class="table">
        <thead><tr>' . $this->getTableHead() . '</tr></thead>
        <tbody></tbody>
        </table>';
    }

    public function getTableHead()
    {
        return '
            <th>foobar</th>
            <th>foobar</th>
            <th>foobar</th>
            <th>
            ' . $this->getCreateBtn() . '
            </th>';
    }

    /**
     * Returns the create button if user is allowed to create new records.
     *
     * @return string
     */
    private function getCreateBtn()
    {
        $btn = '';

        // if user has permission to create new records
        if (isset($this->config['permissions']['create'])) {
            if ($this->config['permissions']['create'] === true) {
                $btn = '<a href="#" class="btn btn-success">' . $this->trans('actions.create') . '</a>';
            }
        }

        return $btn;
    }

    /**
     * Returns a DataTable translation text for given key.
     *
     * @param $key
     * @return array|null|string
     */
    private function trans($key)
    {
        return __('pcmn.datatable.' . $key);
    }

    /**
     * Outputs the JavaScript part for use in View.
     *
     * @return string
     */
    public function script()
    {
        return sprintf('
        $("#table").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "%s",
            "language": {
                "url": "%s"
            },
            "columns":  [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" }
            ]
        });', route("pcmn.datatable.index", "home"), config('pcmn.datatable.languageUrl'));
    }

    public function process()
    {
        try {
            $query = $this->query();
            $query = $query->get();
        } catch (\Exception $e) {
            return [
                'draw' => (int)$this->parameters['draw'],
                'error' => $error = $e->getMessage()
            ];
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

    private function query()
    {
        $this->table = 'pcmn_user';
        return DB::table($this->table)->take($this->parameters['length']);
    }
}