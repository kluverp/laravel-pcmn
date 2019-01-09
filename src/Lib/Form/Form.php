<?php

namespace Kluverp\Pcmn\Lib\Form;

use Kluverp\Pcmn\Lib\TableConfig;
use Kluverp\Pcmn\Models\BaseModel;
use Illuminate\Support\Facades\Validator;

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
    private $model = null;

    /**
     * The form action.
     *
     * @var null
     */
    private $action = '';

    /**
     * The form method.
     *
     * @var string
     */
    private $method = 'post';

    /**
     * Form constructor.
     * @param TableConfig $config
     * @param $options
     */
    public function __construct(TableConfig $config, $model, $options = [])
    {
        // set config
        $this->config = $config;

        // set form method
        if (!empty($options['method'])) {
            $this->method = $options['method'];
        }

        // set form action
        if (!empty($options['action'])) {
            $this->action = $options['action'];
        }

        // set data record
        $this->model = $model;

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
            if ($fieldObj = FieldFactory::make($name, $field, $this->getValue($name))) {
                $this->fields[] = $fieldObj;
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
        if (!empty($this->model)) {
            return $this->model->{$name};
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
        return $this->method;
    }

    public function getValidator() {
        return Validator::make(request()->all(), $this->getRules());
    }

    /**
     * Returns the form values for database storage.
     *
     * @return array
     */
    public function getForStorage()
    {
        // init data handler
        $dataHandler = new FormData($this->config, request()->except(['_token', '_method']));

        return $dataHandler->getForStorage();
    }

    public function getRules()
    {
        $allRules = [];
        foreach($this->getFields() as $field)
        {
            if($rules = $field->getRules())
            {
                $allRules[$field->getName()] = $rules;
            }
        }

        return $allRules;
    }
}