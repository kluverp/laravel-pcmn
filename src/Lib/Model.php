<?php

namespace Kluverp\Pcmn\Lib;

use DB;

class Model
{
    private $table = '';

    private $id = null;

    public function __construct($table, $id)
    {
    }

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
}