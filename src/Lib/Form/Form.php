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
    public function __construct(TableConfig $config, $options = [])
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
        if (!empty($options['data'])) {
            $this->data = $options['data'];
        }

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
            if ($fieldObj = FieldFactory::make($name, $field)) {
                $fieldObj->setValue($this->getValue($name));
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
        return $this->method;
    }

    /**
     * Returns the validation errors.
     *
     */
    public function getErrors()
    {

    }

    public function validate()
    {
        return true;
        // have a formvalidator class validate our form
        //$validator = FormValidator::make($form, $config);
        /*if($validator->validates()) {
            return true;
        }

        return $validator;*/
    }

    public function getForStorage()
    {
        $data = [];
        foreach($this->getFields() as $field) {
            if(request()->get($field->)) {
                return     request()->get($name);
            }
        }

        dd($data);

        // init data handler
        $dataHandler = new DataHandler($this->config, request()->except(['_token', '_method']));

        dd($dataHandler->getForStorage());

        return $dataHandler->getForStorage();
    }
}