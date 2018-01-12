<?php

namespace Kluverp\Pcmn\Lib;

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
    private $tableDef = [];

    /**
     * Menu constructor.
     *
     * @param array $menuDef
     * @param array $tableDef
     */
    public function __construct(array $menuDef = [], $tableDef = [])
    {
        // set our definitions
        $this->menuDef = $menuDef;
        $this->tableDef = $tableDef;
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

                    if (isset($this->tableDef[$table])) {
                        $table = [
                            'label' => $this->getLabel($table),
                            'icon' => $this->getIcon($table),
                            'url' => route('pcmn.content.index', $table),
                            'active' => false,
                            'records' => self::getRecordCount($table)
                        ];
                    } else {
                        $table = [
                            'label' => '&lt; ! missing table definition &gt;',
                            'icon' => false,
                            'url' => false,
                            'active' => false,
                            'records' => 0
                        ];
                    }
                }
            }
        }

        return $this->menuDef;
    }

    private static function getRecordCount($table)
    {
        return rand(4, 23);
    }


    private function getLabel($table)
    {
        // check if key exists
        if (isset($this->tableDef[$table]['title']['plural'])) {
            return $this->tableDef[$table]['title']['plural'];
        }

        return '';
    }

    private function getIcon($table)
    {
        // check if key exists
        if (isset($this->tableDef[$table]['icon'])) {
            return $this->tableDef[$table]['icon'];
        }

        return false;
    }
}