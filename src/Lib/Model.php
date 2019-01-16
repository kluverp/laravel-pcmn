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
    private $__table = null;
    private $__prefix = null;
    private $__data = [];

    /**
     * Model constructor.
     * @param $table
     */
    public function __construct($table, $data = [])
    {
        //$this->setData(new \stdClass());
        $this->setTable($table);
        $this->setPrefix(config('pcmn.config.table_prefix'));
        $this->setData($data);

        Builder::macro('softdelete', function () {
            $values = [
                "deleted_at" => \Carbon\Carbon::now()
            ];

            return Builder::update($values);
        });
    }

    public function getTable()
    {
        return $this->__table;
    }

    public function setTable($table)
    {
        return $this->__table = $table;
    }

    private function getPrefix()
    {
        return $this->__prefix;
    }

    public function setPrefix($prefix)
    {
        return $this->__prefix = $prefix;
    }

    public function setData($data)
    {
        return $this->__data = $data;
    }

    public function getData()
    {
        if (!$this->__data) {
            return new \stdClass();
        }
        return $this->__data;
    }

    private function mergeData(array $data)
    {
        return $this->setData(array_merge((array)$this->getData(), $data));
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

        return new self($this->getTable(), $record);
    }

    /**
     * Create a new record.
     *
     * @param $table
     * @param $data
     * @return mixed
     */
    public function create(array $data, $parentTable = null, $parentId = null)
    {
        // insert new record
        if (DB::table($this->getTable())->insert($data)) {
            if ($id = DB::getPdo()->lastInsertId()) {
                $data['id'] = $id;
                $this->createXref($parentTable, $parentId, $id);
                $this->mergeData($data);
                return $id;
            }
        }

        return false;
    }


    /**
     * Update record.
     *
     * @param $table
     * @param $id
     * @param $data
     */
    public function update(array $data = [], $parentTable = null, $parentId = null)
    {
        $update = DB::table($this->getTable())
            ->where('id', $this->getId())
            ->update($data);
        if ($update) {
            $this->mergeData($data);
        }
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

    /**
     * Returns the ID for the first record. In case this does not start at one.
     * Is used for 'single' record tables.
     *
     * @param $table
     * @return bool
     */
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
     * Returns a parent record.
     *
     * @param $table
     * @return mixed
     */
    public function parent()
    {
        $xref = DB::table($this->getPrefix() . 'xref')
            ->where('child_table', $this->getTable())
            ->where('child_id', $this->getId())
            ->first();


        if ($xref) {
            $parent = new self($xref->parent_table);
            return $parent->find($xref->parent_id);
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
            $ids = DB::table($this->getPrefix() . 'xref')
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
            return DB::table($this->getPrefix() . 'xref')->create([
                'parent_table' => $parentTable,
                'parent_id' => $parentId,
                'child_table' => $this->getTable(),
                'child_id' => $id
            ]);
        }
    }

    /**
     * Returns data from model.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getData()->$name;
    }

    public function getId()
    {
        return $this->getData()->id;
    }

}