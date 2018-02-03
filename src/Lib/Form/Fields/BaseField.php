<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;

use Kluverp\Pcmn\Lib\Form\Fields\FieldOption;

class BaseField
{
    /**
     * Field name.
     *
     * @var null
     */
    protected $name = null;

    /**
     * Field config.
     *
     * @var null
     */
    protected $config = null;

    /**
     * The form value.
     *
     * @var null
     */
    protected $value = null;

    /**
     * Input type.
     *
     * @var string
     */
    protected $type = 'text';

    /**
     * View to use.
     *
     * @var string
     */
    protected $view = 'input';

    /**
     * Options in case of 'radio', 'select' and 'checkbox'.
     *
     * @var array
     */
    protected $options = [];

    /**
     * BaseField constructor.
     * @param $name
     * @param $config
     * @param $value
     */
    public function __construct($name, $config, $value)
    {
        $this->name = $name;
        $this->config = $config;
        $this->value = $value;

        // check for options and parse them
        if (!empty($config['options'])) {
            $this->parseOptions($config['options'], $config);
        }
    }

    /**
     * Returns the view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function html()
    {
        return $this->getView();
    }

    /**
     * Returns the ID attr.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getName();
    }

    /**
     * Returns the field name.
     *
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the label.
     *
     * @return string
     */
    public function getLabel()
    {
        if (isset($this->config['label'])) {
            return $this->config['label'];
        }
        return '&lt;missing label&gt;';
    }

    /**
     * Returns the placeholder.
     *
     * @return string
     */
    public function getPlaceholder()
    {
        if (isset($this->config['placeholder'])) {
            return $this->config['placeholder'];
        }
        return $this->getLabel();
    }

    /**
     * Returns the form field value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return old($this->getName(), $this->value);
    }

    /**
     * Returns the input type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the Fields' view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getView()
    {
        return view('pcmn::content.form.fields.' . $this->view, [
            'id' => $this->getId(),
            'label' => $this->getLabel(),
            'attr' => $this->getAttributeStr(),
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'options' => $this->getOptions()
        ]);
    }

    /**
     * Returns the attribute string for use in view.
     *
     * @return string
     */
    protected function getAttributeStr()
    {
        $str = '';
        foreach ($this->getAttributes() as $key => $value) {
            $str .= sprintf(' %s="%s"', $key, $value);
        }

        return $str;
    }

    /**
     * Returns the fields' attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return [
            'class' => 'form-control',
            'id' => $this->getId(),
            'name' => $this->getName(),
            'placeholder' => $this->getPlaceholder(),
            'value' => $this->getValue(),
            'type' => $this->getType()
        ];
    }

    /**
     * Parses the options string.
     *
     * @param $configOptions
     * @return array
     */
    protected function parseOptions($configOptions, $showEmpty = false)
    {
        $options = [];

        // parse the options string and split on pipe
        $rawOptions = explode('|', $configOptions);

        // add empty option if set
        if($showEmpty) {
            $options[] = new FieldOption($showEmpty, null, '');
        }

        // build the options array
        foreach ($rawOptions as $rawOption) {
            // explode the options str
            $values = explode(',', $rawOption);

            // add parsed option
            $options[] = new FieldOption($values[0], $values[1], $values[2]);
        }

        // set options array
        return $this->options = $options;
    }

    /**
     * Returns the options array.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}