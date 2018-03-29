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
     * The logic to execute on the value.
     */
    public function present()
    {
        return $this->value;
    }
}