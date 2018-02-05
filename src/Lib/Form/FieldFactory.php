<?php

namespace Kluverp\Pcmn\Lib\Form;

/**
 * Class FieldFactory
 * @package Kluverp\Pcmn\Lib\Form
 */
class FieldFactory
{
    /**
     * Factory for building form fields.
     *
     * @param $name
     * @param $config
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function make($name, $config, $value)
    {
        // get classname based on given 'type'
        $className = self::typeToClassname($config['type']);

        // check if the class exists
        if (!class_exists($className)) {
            throw new \Exception('Invalid field type specified (' . $config['type'] . ')');
        }

        return new $className($name, $config, $value);
    }

    /**
     * Translate the given 'type' to a classname.
     *
     * @param $type
     * @return string
     */
    private static function typeToClassName($type)
    {
        return __NAMESPACE__ . '\Fields\\' . studly_case($type);
    }
}