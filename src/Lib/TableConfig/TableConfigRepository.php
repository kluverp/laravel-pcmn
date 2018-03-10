<?php

namespace Kluverp\Pcmn\Lib\TableConfig;

use Kluverp\Pcmn\Lib\TableConfig;

/**
 * Class TableConfigRepository
 * @package Kluverp\Pcmn\Lib\TableConfig
 */
class TableConfigRepository
{
    /**
     * Container holding initialized table configs.
     *
     * @var array
     */
    private $tableConfigs = [];

    public function __construct()
    {
        logger()->debug('TableConfigRepository init');
    }

    /**
     * returns a table config from container, or creates one.
     *
     * @param $table
     * @return TableConfig|mixed
     */
    public function find($table)
    {
        // check if requested table config is already set
        if (!empty($this->tableConfigs[$table])) {
            return $this->tableConfigs[$table];
        }

        if ($config = config('pcmn.tables.' . $table)) {
            // set and return new table config
            return $this->tableConfigs[$table] = new TableConfig($table, config('pcmn.tables.' . $table));
        }

        return false;
    }
}
