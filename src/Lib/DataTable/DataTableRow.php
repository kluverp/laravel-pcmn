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
                $presenter = $this->config->getField($key)['type'];
            }

            $presentedValue = PresenterFactory::apply($presenter, $this->getColumnValue($key));
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
        $buttons = '';
        $buttons .= ' ' . $this->getReadBtn($rowId);
        $buttons .= ' ' . $this->getUpdateBtn($rowId);
        $buttons .= ' ' . $this->getDeleteBtn($rowId);

        return '<div class="text-right">' . $buttons . '</div>';
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
            <a class="btn btn-danger btn-sm" href="' . DataTable::route('destroy',
                    [$this->config->getTable(), $rowId]) . '">
                ' . DataTable::trans('actions.delete') . '
            </a>';
        }

        return false;
    }

    /**
     * Returns the 'edit' button.
     *
     * @param $rowId
     * @return bool|string
     */
    private function getUpdateBtn($rowId)
    {
        if ($this->config->canUpdate()) {
            return '
            <a class="btn btn-primary btn-sm" href="' . DataTable::route('edit', [$this->config->getTable(), $rowId]) . '">
                ' . DataTable::trans('actions.update') . '
            </a>';
        }

        return false;
    }

    /**
     * Returns the button to 'show' action.
     *
     * @param $rowId
     * @return bool|string
     */
    private function getReadBtn($rowId)
    {
        if ($this->config->canRead()) {
            return '
            <a class="btn btn-default btn-sm" href="' . DataTable::route('show', [$this->config->getTable(), $rowId]) . '">
                ' . DataTable::trans('actions.read') . '
            </a>';
        }

        return false;
    }
}