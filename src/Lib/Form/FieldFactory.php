<?php

namespace Kluverp\Pcmn\Lib\Form;

use Kluverp\Pcmn\Lib\Form\Fields\Input;
use Kluverp\Pcmn\Lib\Form\Fields\Email;
use Kluverp\Pcmn\Lib\Form\Fields\Radio;
use Kluverp\Pcmn\Lib\Form\Fields\Select;

class FieldFactory
{
    /**
     * Factory for building form fields.
     *
     * @param $name
     * @param $config
     * @param $value
     * @return bool|Email|Input|Radio|Select
     */
    public static function make($name, $config, $value)
    {
        $field = false;

        // built form field based on config
        switch ($config['type']) {
            case 'input':
                $field = new Input($name, $config, $value);
                break;
            case 'email':
                $field = new Email($name, $config, $value);
                break;
            case 'radio':
                $field = new Radio($name, $config, $value);
                break;
            case 'select':
                $field = new Select($name, $config, $value);
                break;
            default:
        }

        return $field;
    }
}