<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;

class Checkbox extends Select
{
    /**
     * Radio type.
     *
     * @var string
     */
    protected $type = 'checkbox';

    public function getAttributes()
    {
        return [];
    }


    public function getValue()
    {
        return old($this->getName(), explode(',', $this->value));
    }
}
