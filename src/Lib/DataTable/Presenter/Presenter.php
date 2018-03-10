<?php

namespace Kluverp\Pcmn\Lib\DataTable\Presenter;

class Presenter
{
    /**
     * The value to present.
     *
     * @var null
     */
    protected $value = null;

    /**
     * Boolean constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Factory method to make a new presenter.
     *
     * @param $presenterName
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function make($presenterName, $value)
    {
        $class = 'Kluverp\Pcmn\Lib\DataTable\Presenter\\' . studly_case($presenterName);
        if (class_exists($class)) {
            return new $class($value);
        }

        return new self($value);
    }

    /**
     * The logic to execute on the value.
     */
    public function present()
    {
        return $this->value;
    }

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
}