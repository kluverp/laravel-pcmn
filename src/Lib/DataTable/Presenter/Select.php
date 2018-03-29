<?php

namespace Kluverp\Pcmn\Lib\DataTable\Presenter;

use Illuminate\Support\HtmlString;

class Select extends Presenter
{
    /**
     * Present the string.
     *
     * @return HtmlString
     */
    public function present()
    {
        return $this->value . 'sel';
    }
}