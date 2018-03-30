<?php

namespace Kluverp\Pcmn\Lib\DataTable\Presenter;

use Kluverp\Pcmn\Lib\TableConfig;

class Presenter
{
    /**
     * The value to present.
     *
     * @var null
     */
    protected $value = null;

    /**
     *
     * @var null
     */
    protected $field = [];

    /**
     * Boolean constructor.
     * @param $value
     */
    public function __construct($value, $field = [])
    {
        $this->value = $value;
        $this->field = $field;
    }

    /**
     * The logic to execute on the value.
     */
    public function present()
    {
        return $this->value;
    }
}