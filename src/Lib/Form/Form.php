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
     * Form constructor.
     * @param TableConfig $config
     */
    public function __construct(TableConfig $config)
    {
        // set config
        $this->config = $config;

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
            if ($obj = FieldFactory::make($name, $field)) {
                $this->fields[] = $obj;
            }
        }
    }

    /**
     * Returns the Form view.
     *
     * @return string
     */
    public function html()
    {
        return view('pcmn::content.form.form', [
            'fields' => $this->getFields()
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
}