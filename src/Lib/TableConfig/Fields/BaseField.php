<?php

namespace Kluverp\Pcmn\Lib\TableConfig\Fields;

class BaseField
{
    public $type = null;
    public $label = null;
    public $help_text = null;

    public function __construct($config)
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}