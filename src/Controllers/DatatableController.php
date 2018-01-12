<?php

namespace Kluverp\Pcmn;

use Illuminate\Http\Request;
use Kluverp\Pcmn\Lib\DataTable;

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
    public function index($table, Request $request)
    {
        // init new DataTable processor
        $dataTable = new DataTable(config('pcmn.tables.' . $table), $request->all());


        // output JSON result
        return response()->json($dataTable->process());
    }
}