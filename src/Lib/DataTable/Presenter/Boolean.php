<?php

namespace Kluverp\Pcmn\Lib\DataTable\Presenter;

use Illuminate\Support\HtmlString;

class Boolean extends Presenter
{
    /**
     * Present the string.
     *
     * @return HtmlString
     */
    public function present()
    {
        return $this->value ? self::labelTrue() : self::labelFalse();
    }

    /**
     * Returns the true label string.
     *
     * @return string
     */
    private static function labelTrue()
    {
        return '<span class="badge badge-success">' . __('pcmn::presenters.boolean.true') . '</span>';
    }

    /**
     * Returns the false label string.
     *
     * @return string
     */
    private static function labelFalse()
    {
        return '<span class="badge badge-danger">' . __('pcmn::presenters.boolean.false') . '</span>';
    }
}