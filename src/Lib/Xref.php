<?php

namespace Kluverp\Pcmn\Lib;

use Kluverp\Pcmn\Lib\TableConfig\TableConfigRepository;
use Kluverp\Pcmn\Lib\DataTable\DataTable;
use Kluverp\Pcmn\Lib\Model;

class Xref
{
    /**
     * Xref constructor.
     * @param TableConfigRepository $configRepo
     */
    public function __construct(TableConfigRepository $configRepo)
    {
        $this->configRepo = $configRepo;
    }

    /**
     * @param $config
     * @return array
     */
    public function datatables($config, Model $model = null)
    {
        $datatables = [];

        if (!$xrefs = config('pcmn.xref.' . $config->getTable())) {
            return $datatables;
        }

        foreach ($xrefs as $xref) {
            if ($config = $this->configRepo->find($xref)) {
                $datatables[] = new DataTable($config, [], $model);
            }
        }

        return $datatables;
    }
}
