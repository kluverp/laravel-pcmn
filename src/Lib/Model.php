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
    private $__cols = [];

    /**
     * Model constructor.
     * @param $table
     */
    public function __construct($table, $data = [])
    {
        $this->setTable($table);
        $this->setPrefix(config('pcmn.config.table_prefix'));
        $this->setData($data);
        $this->setCols(Schema::getColumnListing($table));
    }

    /**
     * Returns database table.
     *
     * @return null
     */
    public function getTable()
    {
        return $this->__table;
    }

    /**
     * Set database table.
     *
     * @param $table
     * @return mixed
     */
    public function setTable($table)
    {
        return $this->__table = $table;
    }

    /**
     * Set record columns.
     *
     * @param $cols
     * @return mixed
     */
    private function setCols($cols)
    {
        return $this->__cols = $cols;
    }

    /**
     * Returns all table columns.
     *
     * @return array
     */
    public function getCols()
    {
        return $this->__cols;
    }

    /**
     * Check if given column exists.
     *
     * @param $col
     * @return bool
     */
    public function hasCol($col)
    {
        return in_array($col, $this->getCols());
    }

    /**
     * Returns the table prefix.
     *
     * @return null
     */
    private function getPrefix()
    {
        return $this->__prefix;
    }

    /**
     * Set table prefix.
     *
     * @param $prefix
     * @return mixed
     */
    public function setPrefix($prefix)
    {
        return $this->__prefix = $prefix;
    }

    /**
     * Set model data.
     *
     * @param $data
     * @return mixed
     */
    public function setData($data)
    {
        return $this->__data = $data;
    }

    /**
     * Returns model data.
     *
     * @return array|\stdClass
     */
    public function getData()
    {
        if (!$this->__data) {
            return new \stdClass();
        }
        return $this->__data;
    }

    /**
     * Merge new data with current model object after 'create' or 'update'.
     *
     * @param array $data
     * @return mixed
     */
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
        if ($this->hasCol('updated_at')) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        if ($this->hasCol('created_at')) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

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
        unset($data['id']);

        if ($this->hasCol('updated_at')) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $update = DB::table($this->getTable())
            ->where('id', $this->getId())
            ->update($data);
        if ($update) {
            $this->mergeData($data);
        }
    }

    /**
     * Deletes the record.
     * Checks if 'deleted_at' column is present, if so
     * we perform a softdelete, otherwise full delete.
     */
    public function delete($id)
    {
        $query = DB::table($this->getTable())
            ->where('id', $id);

        if ($this->hasCol('deleted_at')) {
            return $query->softdelete();
        }

        return $query->delete();
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
     * Returns all child ID's.
     *
     * @return mixed
     */
    public function childIds($table)
    {
        return DB::table($this->getPrefix() . 'xref')
            ->where('parent_table', $this->getTable())
            ->where('parent_id', $this->getId())
            ->where('child_table', $table)
            ->pluck('id');
    }

    /**
     * Returns all children.
     *
     * @param $table
     * @return array
     */
    public function children($table)
    {
        $result = [];
        $model = new self($table);

        foreach ($this->childIds($table) as $id) {
            $result[] = $model->find($id);
        }

        return $result;
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
        if (is_numeric($parentId) && is_string($parentTable)) {
            return DB::table($this->getPrefix() . 'xref')->insert([
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
        $data = $this->getData();
        if(property_exists($data, $name)) {
            return $data->{$name};
        }
    }

    public function getId()
    {
        return $this->getData()->id;
    }

}