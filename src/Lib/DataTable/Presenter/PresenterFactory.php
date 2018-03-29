<?php

namespace Kluverp\Pcmn\Lib\DataTable\Presenter;

class PresenterFactory
{
    /**
     * Create new presenter and apply it on the value given.
     *
     * @param $presenter
     * @param $value
     * @return mixed
     */
    public static function apply($presenter, $value)
    {
        $presenter = static::make($presenter, $value);

        return $presenter->present();
    }

    /**
     * Factory method to make a new presenter.
     *
     * @param $presenterName
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function make($presenter, $value)
    {
        // if presenter is of Closur form, we init the Closure presenter class.
        if ($presenter instanceof \Closure) {
            return new Closure($value, $presenter);
        };

        // otherwise we translate the presenter name to a Class
        $class = self::getPresenterClass($presenter);
        if (class_exists($class)) {
            return new $class($value);
        }

        return new Presenter($value);
    }

    /**
     * Translate the presenter to namespaced classname.
     *
     * @param $presenter
     * @return string
     */
    public static function getPresenterClass($presenter)
    {
        return 'Kluverp\Pcmn\Lib\DataTable\Presenter\\' . studly_case($presenter);
    }
}