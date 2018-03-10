<?php

namespace Kluverp\Pcmn\Lib\DataTable\Presenter;

class Text extends Presenter
{
    /**
     * The string limit.
     *
     * @var int
     */
    private static $limit = 50;

    /**
     * Present the string.
     *
     * @return null|string
     */
    public function present()
    {
        if (strlen($this->value) > self::$limit) {
            return substr($this->value, 0, self::$limit) . '...';
        }

        return $this->value;
    }
}