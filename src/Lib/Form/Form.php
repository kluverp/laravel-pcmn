<?php

namespace Kluverp\Pcmn\Lib\Form;

use Kluverp\Pcmn\Lib\TableConfig;

class Form
{
    /**
     * The tableconfig instance.
     *
     * @var TableConfig|null
     */
    private $config = null;

    /**
     * The fields array.
     *
     * @var array
     */
    private $fields = [];

    /**
     * The database record.
     *
     * @var array
     */
    private $data = [];

    /**
     * The form action.
     *
     * @var null
     */
    private $action = null;

    /**
     * Form constructor.
     * @param TableConfig $config
     */
    public function __construct(TableConfig $config, $data = [], $action = null)
    {
        // set config
        $this->config = $config;

        // set the record
        $this->data = $data;

        $this->action = $action;

        // build the form
        $this->build();
    }

    /**
     * Builds all the form fields
     */
    public function build()
    {
        // build each field in the form definition
        foreach ($this->config->getFields() as $name => $field) {
            if ($obj = FieldFactory::make($name, $field, $this->getValue($name))) {
                $this->fields[] = $obj;
            }
        }
    }

    /**
     * Returns the value for given field name.
     *
     * @param $name
     * @return null
     */
    private function getValue($name)
    {
        // check if data is set
        if (!empty($this->data)) {
            // check if the property on this data obj is set
            if (property_exists($this->data, $name)) {
                return $this->data->{$name};
            }
        }

        return null;
    }

    /**
     * Returns the Form view.
     *
     * @return string
     */
    public function html()
    {
        return view('pcmn::content.form.form', [
            'fields' => $this->getFields(),
            'action' => $this->getAction(),
            'method' => $this->getMethod()
        ]);
    }

    /**
     * Returns fields array.
     *
     * @return array
     */
    protected function getFields()
    {
        return $this->fields;
    }

    /**
     * Returns the action.
     *
     * @return null
     */
    protected function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the method based on '/edit' in URL.
     *
     * @return string
     */
    protected function getMethod()
    {
        if (strpos($this->action, '/edit')) {
            return 'PUT';
        }

        return 'POST';
    }
}