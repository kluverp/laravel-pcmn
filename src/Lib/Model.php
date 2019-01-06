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
    /**
     * Create a new record.
     *
     * @param $table
     * @param $data
     * @return mixed
     */
    public static function create($table, $data)
    {
        // insert new record
        DB::table($table)->insert($data);

        // get last insert ID
        return DB::getPdo()->lastInsertId();
    }

    /**
     * Get a record.
     *
     * @param $table
     * @param $id
     * @return mixed
     */
    public static function read($table, $id)
    {
        return DB::table($table)->find($id);
    }

    /**
     * Update record.
     *
     * @param $table
     * @param $id
     * @param $data
     */
    public static function update($table, $id, $data)
    {
        return DB::table($table)
            ->where('id', $id)
            ->update($data);
    }

    /**
     * Delete record.
     */
    public static function delete($table, $id)
    {
        return DB::table($table)->where('id', $id)->delete();
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
        if(Schema::hasTable($table)) {
            if($record = DB::table($table)->first()) {
                return $record->id;
            }
        }

        return false;
    }
}