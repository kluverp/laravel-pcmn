<?php

namespace Kluverp\Pcmn\Lib\DataTable;

use Kluverp\Pcmn\Lib\Model;

class DatatableStore
{
    private $model = null;
    private $parameters = [];

    public function __construct($parameters, Model $model = null)
    {
        $this->model = $model;
        $this->parameters = $parameters;
    }

    public function getData()
    {
        return $this->query();
    }

    public function model()
    {
        return $this->model;
    }

    /**
     * Returns a single parameter.
     * Key can be in dot notation.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function parameter($key, $default = null)
    {
        return array_get($this->parameters, $key, $default);
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
        $ids = [];

        $query = DB::table($this->config->getTable())
            ->select($cols)
            ->skip($this->parameters['start'])
            ->take($this->parameters['length']);

// if this is a child record, find the id's to load
        if ($model = $this->model) {
            if ($ids = $model->childIds($this->config->getTable())) {
                $query->whereIn('id', $ids);
            }
        }

        return $query
            ->orderBy($cols[$this->parameters['order'][0]['column']], $this->parameters['order'][0]['dir'])
            ->get();
    }
}