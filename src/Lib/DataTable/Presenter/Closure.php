<?php

namespace Kluverp\Pcmn\Lib\DataTable\Presenter;

class Closure
{
    /**
     * Value to operate on.
     *
     * @var null
     */
    private $value = null;

    /**
     * Closure to call on value.
     *
     * @var \Closure|null
     */
    private $closure = null;

    /**
     * Closure constructor.
     *
     * @param $value
     * @param \Closure $closure
     */
    public function __construct($value, \Closure $closure)
    {
        $this->value = $value;
        $this->closure = $closure;
    }

    /**
     * Present the value by calling the Closure upon it.
     *
     * @return null|string
     */
    public function present()
    {
        return ($this->closure)($this->value);
    }
}