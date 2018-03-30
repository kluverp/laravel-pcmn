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
        if ($options = $this->getOptions()) {
            if (isset($options[$this->value])) {
                return $options[$this->value];
            }
        }

        return $this->value;
    }

    /**
     * Returns the options for this field.
     *
     * @return array
     */
    private function getOptions()
    {
        if (!empty($this->field['options'])) {
            return $this->field['options'];
        }

        return [];
    }
}