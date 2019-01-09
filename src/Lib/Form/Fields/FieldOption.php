<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;


class FieldOption
{
    /**
     * Label for the option.
     *
     * @var string
     */
    protected $label = '';

    /**
     * Value of the option.
     *
     * @var null
     */
    protected $value = null;

    /**
     * FieldOption constructor.
     *
     * @param $label
     * @param $value
     * @param $color
     */
    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Returns the option value.
     *
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns if the given value is checked.
     * If index is given, then we default to the first option if the value is not set.
     *
     * @param $value
     * @param null $index
     * @return bool
     */
    public function isChecked($value, $index = null)
    {
        // checkbox or multiselect
        if(is_array($value)) {
            return in_array($this->value, $value);
        }

        // radio
        // if no value is set, and it is the first option, then set it as default.
        if (isset($index) && $index == 0 && $value == null) {
            return true;
        }

        return $this->value == $value;
    }

    /**
     * Alias for 'isChecked()'.
     *
     * @param $value
     * @param null $index
     * @return bool
     */
    public function isSelected($value, $index = null)
    {
        return $this->isChecked($value, $index);
    }
}