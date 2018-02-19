<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;


class Password extends BaseField
{
    /**
     * Input type.
     *
     * @var string
     */
    protected $type = 'password';

    /**
     * Returns the value as encrypted string.
     *
     * @return string
     */
    public function getValue()
    {
        $value = parent::getValue();
        return sha1($value);
    }

    public function getAttributes()
    {
        $attrs = parent::getAttributes();
        unset($attrs['value']);
        return $attrs;
    }
}