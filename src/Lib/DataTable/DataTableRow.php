<?php

namespace Kluverp\Pcmn\Lib\DataTable;

use Kluverp\Pcmn\Lib\TableConfig;
use Kluverp\Pcmn\Lib\DataTable\Presenter\PresenterFactory;
use DB;

class DataTableRow
{
    /**
     * The row object.
     *
     * @var null
     */
    private $row = null;

    /**
     * The config object.
     *
     * @var TableConfig|null
     */
    private $config = null;

    private $transNs = 'pcmn::datatable';
    private $routeNs = 'pcmn.content';

    /**
     * DataTableRow constructor.
     * @param $row
     * @param TableConfig $config
     */
    public function __construct($row, TableConfig $config)
    {
        // set config
        $this->config = $config;

        $this->row = $row;

        // apply presenters if any
        $this->applyPresenters();

        // create row actions
        $this->row->actions = $this->getActions($row->id);

        return $this->row;
    }

    /**
     * Applies column presenters if any are defined.
     *
     */
    private function applyPresenters()
    {
        foreach ($this->config->getIndex() as $key => $value) {
            if (!empty($value['presenter'])) {
                $presenter = $value['presenter'];
            } else {
                $presenter = $this->config->getFieldAttr($key, 'type');
            }

            $presentedValue = PresenterFactory::apply($presenter, $this->getColumnValue($key),
                $this->config->getField($key));
            $this->setColumnValue($key, $presentedValue);
        }
    }

    /**
     * Returns the column value for given key (the database field value).
     *
     * @param $key
     * @return mixed
     */
    private function getColumnValue($key)
    {
        return $this->row->{$key};
    }

    /**
     * Set (overwrite) the row' field value with new (presented) value.
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    private function setColumnValue($key, $value)
    {
        return $this->row->{$key} = $value;
    }

    /**
     * Returns the "Action" buttons for each row.
     *
     * @param $rowId
     * @return string
     */
    private function getActions($rowId)
    {
        return view('pcmn::datatable.actions', [
            'config' => $this->config,
            'rowId' => $rowId,
            'routeNs' => $this->routeNs,
            'transNs' => $this->transNs
        ])->render();
    }
}