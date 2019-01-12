<?php

namespace Kluverp\Pcmn\Lib;

use DB;
use Schema;

/**
 * Class Model
 * @package Kluverp\Pcmn\Lib
 */
class Model
{
    private $table = null;

    public function __construct($table)
    {
        $this->setTable($table);
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable($table)
    {
        return $this->table = $table;
    }

    public function datatable()
    {
        if(is_numeric($parentId) && is_string($parentTable)) {
            $ids = DB::table('pcmn_xrefs')
                ->where('parent_table', $parentTable)
                ->where('parent_id', $parentId)
                ->where('child_table', $this->getTable())
                ->pluck('child_id');
        }
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
        return DB::table($this->getTable())->find($id);
    }

    /**
     * Create a new record.
     *
     * @param $table
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        // insert new record
        DB::table($this->getTable())->insert($data);

        // get last insert ID
        return DB::getPdo()->lastInsertId();
    }


    /**
     * Update record.
     *
     * @param $table
     * @param $id
     * @param $data
     */
    public function update($id, array $data = [])
    {
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
}