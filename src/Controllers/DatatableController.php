<?php

namespace Kluverp\Pcmn;

use Illuminate\Http\Request;
use Kluverp\Pcmn\Lib\DataTable\DataTable;
use Kluverp\Pcmn\Lib\Model;
use Kluverp\Pcmn\Lib\TableConfig;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DatatableController extends BaseController
{
    /**
     * Load the DataTable.
     *
     * @param $table
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($table, $parentTable = null, $parentId = null, Request $request)
    {
        // create new TableConfig object
        if (!$config = new TableConfig($table, config('pcmn.tables.' . $table))) {
            return abort('Missing table configuration', 422);
        }

        $model = new Model($parentTable);
        $model = $model->find($parentId);

        // init new DataTable processor
        $dataTable = new DataTable($config, $request->all(), $model);

        // output JSON result
        return response()->json($dataTable->ajax());
    }
}