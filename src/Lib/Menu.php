<?php

namespace Kluverp\Pcmn\Lib;

use DB;
use Illuminate\Support\Facades\Schema;
use Kluverp\Pcmn\Lib\TableConfig\TableConfigRepository;

/**
 * Class Menu
 * @package Kluverp\Pcmn\Lib
 */
class Menu
{
    /**
     * Menu definition from config file. ("/config/pcmn/menu.php")
     *
     * @var array
     */
    private $menuDef = [];

    /**
     * Table definition from config file. ("/config/pcmn/tables")
     *
     * @var array
     */
    private $tableRepo = [];

    /**
     * Menu constructor.
     *
     * @param array $menuDef
     * @param TableConfigRepository $tableConfigRepo
     */
    public function __construct(array $menuDef = [], TableConfigRepository $tableConfigRepo)
    {
        // set our definitions
        $this->menuDef = $menuDef;
        $this->tableRepo = $tableConfigRepo;
    }

    /**
     * Returns the menu array.
     *
     * @return array
     */
    public function getMenu()
    {
        foreach ($this->menuDef as $key => &$item) {

            if (isset($item['tables'])) {

                foreach ($item['tables'] as &$table) {

                    $table = $this->getItem($table);
                }
            }
        }

        return $this->menuDef;
    }

    /**
     * Returns the menu item.
     *
     * @param $table
     * @return array
     */
    private function getItem($table)
    {
        $item = [
            'label' => '&lt;missing table definition&gt;',
            'icon' => false,
            'url' => false,
            'records' => 0,
            'active' => false
        ];

        if ($definition = $this->tableRepo->find($table)) {
            $item = [
                'label' => $definition->getTitle('plural'),
                'icon' => $definition->getIcon(),
                'url' => $definition->getIndexUrl(),
                'records' => $definition->getRecordCount(),
                'active' => false
            ];
        }

        return $item;
    }
}