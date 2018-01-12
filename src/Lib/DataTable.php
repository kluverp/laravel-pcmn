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
        $this->parameters = $parameters;
    }

    /**
     * Outputs the HTML part for use in View.
     */
    public function html()
    {
        return '
        <table id="table" class="table">
        <thead><tr>'. $this->getTableHead() .'</tr></thead>
        <tbody></tbody>
        </table>';
    }

    public function getTableHead()
    {
        return '<th>foobar</th><th>foobar</th><th>foobar</th>';
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