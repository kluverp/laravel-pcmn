<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;

class Slug extends BaseField
{
    /**
     * Returns the form field value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return old($this->getName(), $this->value);
    }
}