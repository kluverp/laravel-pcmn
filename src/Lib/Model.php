<?php

namespace Kluverp\Pcmn\Lib;

use DB;
use Schema;
use Illuminate\Database\Query\Builder;

/**
 * Class Model
 * @package Kluverp\Pcmn\Lib
 */
class Model
{
    private $table = null;
    private $id = null;
    private $prefix = null;

    public function __construct($table)
    {
        $this->setTable($table);
        $this->setPrefix(config('pcmn.config.table_prefix'));

        Builder::macro('softdelete', function () {
            $values = [
                "deleted_at" => \Carbon\Carbon::now()
            ];

            return Builder::update($values);
        });
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($table)
    {
        return $this->table = $table;
    }

    private function getPrefix()
    {
        return $this->prefix;
    }

    public function setPrefix($prefix)
    {
        return $this->prefix = $prefix;
    }

    public function datatable()
    {

        return DB::table($this->getTable())->find($id);
    }

    /**
     * Get a record.
     *
     * @param $table
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        if ($record = DB::table($this->getTable())->find($id)) {
            $this->id = $id;
        }
        return $record;
    }

    /**
     * Create a new record.
     *
     * @param $table
     * @param $data
     * @return mixed
     */
    public function create($data, $parentTable = null, $parentId = null)
    {
        // insert new record
        DB::table($this->getTable())->insert($data);

        // get last insert ID
        if ($id = DB::getPdo()->lastInsertId()) {
            $this->createXref($parentTable, $parentId, $id);
        }

        return $id;
    }


    /**
     * Update record.
     *
     * @param $table
     * @param $id
     * @param $data
     */
    public function update($id, array $data = [], $parentTable = null, $parentId = null)
    {
        dd($parentId);
        return DB::table($this->getTable())
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Delete record.
     */
    public function delete($id)
    {
        return DB::table($this->getTable())
            ->where('id', $id)
            ->delete();
    }

    public function softdelete($id)
    {
        return DB::table($this->getTable())
            ->where('id', $id)
            ->softdelete();
    }

    /**
     * Returns the number of records for given table.
     *
     * @param $table
     * @return mixed
     */
    public static function recordCount($table)
    {
        if (Schema::hasTable($table)) {
            return DB::table($table)->count();
        }

        return false;
    }

    public static function firstId($table)
    {
        if (Schema::hasTable($table)) {
            if ($record = DB::table($table)->first()) {
                return $record->id;
            }
        }

        return false;
    }

    /**
     * Returns all xref records for given table and parent ID.
     *
     * @param $childTable
     * @param $parentId
     * @return mixed
     */
    public function xrefs($childTable, $parentId)
    {
        $ids = [];

        if (is_numeric($parentId) && is_string($childTable)) {
            $ids = DB::table( $this->getPrefix() . 'xref')
                ->where('parent_table', $this->getTable())
                ->where('parent_id', $parentId)
                ->where('child_table', $childTable)
                ->pluck('child_id');
        }

        return DB::table($childTable)->whereIn('id', $ids)->get();
    }

    /**
     * Store a Xref.
     *
     * @param $parentTable
     * @param $parentId
     * @param $id
     * @return mixed
     */
    private function createXref($parentTable, $parentId, $id)
    {
        if (is_numeric($parentId) && is_string($childTable)) {
            return DB::table($this->getPrefix() . 'xrefs')->create([
                'parent_table' => $parentTable,
                'parent_id' => $parentId,
                'child_table' => $this->getTable(),
                'child_id' => $id
            ]);
        }
    }
}