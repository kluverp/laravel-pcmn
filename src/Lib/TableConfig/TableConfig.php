<?php

namespace Kluverp\Pcmn\Lib;

use Kluverp\Pcmn\Lib\TableConfig\Fields\Select;

class TableConfig
{
    /**
     * The database table name.
     *
     * @var string
     */
    private $table = false;

    /**
     * Screen title (plural for overview, singular for record).
     *
     * @var string
     */
    private $title = ['plural' => false, 'singular' => false];

    /**
     * A page description, telling the user what he can do with the current record(s).
     *
     * @var string
     */
    private $description = false;

    /**
     * The permissions on the datatables.
     *
     * @var array
     */
    private $permissions = [
        'create' => true,
        'read' => true,
        'edit' => true,
        'delete' => true
    ];

    /**
     * Flag indicating the record is a 'single record'. Meaning the list-view can be
     * skipped and the user can go directly to edit screen.
     * This is useful for tables where you always only have one record.
     *
     * @var bool
     */
    private $single_record = false;

    /**
     * The message to show the user if no records are found.
     *
     * @var string
     */
    private $emptyMsg = 'No records found';

    /**
     * The columns used in table 'list' views.
     *
     * @var array
     */
    private $index = [];

    /**
     * The Form field config. This config defines the form layout on 'edit' screens.
     *
     * @var array
     */
    private $fields = [];

    /**
     * TableConfig constructor.
     * @param $table
     * @param $config
     */
    public function __construct($table, $config)
    {
        // set table
        $this->table = $table;

        // set fields
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                if (!empty($value) && property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * Returns the table name e.g: 'news_news'
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Returns the icon for entry.
     */
    public function getIcon()
    {
        // TODO
    }

    /**
     * Returns the title in either plural or singular format.
     *
     * @param string $type
     * @return mixed
     * @throws \Exception
     */
    public function getTitle($type = 'plural')
    {
        // check for title
        if (!in_array($type, ['plural', 'singular'])) {
            throw new \Exception('This is not a valid TableConfig title entry');
        }

        return $this->title[$type];
    }

    /**
     * Returns the description field.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the empty message field
     *
     * @return string
     */
    public function getEmptyMsg()
    {
        return $this->emptyMsg;
    }

    /**
     * Returns the single_record flag
     *
     * @return string
     */
    public function isSingleRecord()
    {
        return (bool)$this->single_record;
    }

    /**
     * Returns the table column definitions
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Returns the form field definitions.
     *
     * @return string
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Returns a single form field definition.
     *
     * @param string $fieldname
     * @param bool $attribute
     * @return bool|mixed
     */
    public function getField($fieldname = '', $attribute = false)
    {
        if (isset($this->fields[$fieldname])) {

            /*if(is_object($this->fields[$fieldname]) && $attribute) {
                return $this->fields[$fieldname]->{$attribute};
            }*/

            if ($attribute && isset($this->fields[$fieldname][$attribute])) {
                return $this->fields[$fieldname][$attribute];
            }

            return $this->fields[$fieldname];
        }

        return false;
    }

    /**
     * Returns a field attribute.
     *
     * @param $fieldname
     * @param $attr
     * @return bool
     */
    public function getFieldAttr($fieldname, $attr)
    {
        if ($field = $this->getField($fieldname)) {
            if (!empty($field[$attr])) {
                return $field[$attr];
            }
        }

        return false;
    }

    /**
     * Returns true if the user is allowed to create new records.
     *
     * @return string
     */
    public function canCreate()
    {
        return $this->permission('create');
    }

    /**
     * Return true if the user is allowed to read record.
     *
     * @return bool
     */
    public function canRead()
    {
        return $this->permission('read');
    }

    /**
     * Returns if the user may edit records.
     *
     * @return bool
     */
    public function canUpdate()
    {
        return $this->permission('update');
    }

    /**
     * Returns if the user may delete records yes/no
     *
     * @return bool
     */
    public function canDelete()
    {
        return $this->permission('delete');
    }

    /**
     * Generic permission checker.
     *
     * @param $permission
     * @return bool
     */
    private function permission($permission)
    {
        // check if given permission is valid
        if (!in_array($permission, ['create', 'read', 'update', 'delete'])) {
            throw new \InvalidArgumentException('Given permission is not one of "create, read, update or delete".');
        }
        // check if values has been set, otherwise default false
        if (isset($this->permissions[$permission])) {
            return $this->permissions[$permission] === true;
        }

        return false;
    }

    /**
     * Returns url to edit page.
     *
     * @param string $action
     * @param array $params
     * @return string
     */
    private function getUrl($action = 'index', $params = [])
    {
        return route('pcmn.content.' . $action, $params);
    }

    /**
     * Returns the URL for use in menu.
     * This returns either the URL to index page, or an URL to the first record in
     * case of a 'single_record' item.
     *
     * @return string
     */
    public function getMenuUrl()
    {
        if($this->isSingleRecord()) {
            return $this->getEditUrl(Model::firstId($this->table));
        }

        return $this->getIndexUrl();
    }

    /**
     * Returns URL to index page.
     *
     * @return string
     */
    public function getIndexUrl()
    {
        return $this->getUrl('index', $this->table);
    }

    /**
     * Returns url to edit page.
     *
     * @param $recordId
     * @return string
     */
    public function getEditUrl($recordId)
    {
        return $this->getUrl('edit', [$this->table, $recordId]);
    }

    /**
     * Returns the number of records in this table.
     *
     * @return mixed
     */
    public function getRecordCount()
    {
        return Model::recordCount($this->getTable());
    }
}