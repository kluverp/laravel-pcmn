<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;

class Select extends BaseField
{
    /**
     * Select.
     *
     * @var string
     */
    protected $type = 'select';

    /**
     * Options in case of 'radio', 'select' and 'checkbox'.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Select constructor.
     * @param $name
     * @param $config
     * @param $value
     */
    public function __construct($name, $config, $value)
    {
        parent::__construct($name, $config, $value);

        // check for options and parse them
        if (!empty($config['options'])) {
            $this->parseOptions($config);
        }
    }


    /**
     * Parses the options string.
     *
     * @param $configOptions
     * @return array
     */
    protected function parseOptions($configOptions)
    {
        $options = [];

        if (!is_array($configOptions['options'])) {
            return $options;
        }

        // add empty option if set
        if (!empty($configOptions['showEmpty'])) {
            $options[] = new FieldOption($configOptions['showEmpty'], null, '');
        }

        foreach ($configOptions['options'] as $value => $label) {
            $options[] = new FieldOption($label, $value);
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

    /**
     * Return the view data.
     *
     * @return array
     */
    protected function getViewData()
    {
        // call parent
        $data = parent::getViewData();

        return array_merge($data, [
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'options' => $this->getOptions()
        ]);
    }
}
