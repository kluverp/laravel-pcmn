<?php

namespace Kluverp\Pcmn\Lib\Form;

use Kluverp\Pcmn\Lib\Form\Fields\Input;

class FieldFactory
{
    /**
     * Factory for building form fields.
     *
     * @param $name
     * @param $config
     * @return bool|string
     */
    public static function make($name, $config)
    {
        $field = false;

        // built form field based on config
        switch ($config) {
            case 'input':
                $field = new Input($name, $config);
                break;
            case 'radio':
                $field = '';
                break;
            default:
        }

        return $field;
    }
}