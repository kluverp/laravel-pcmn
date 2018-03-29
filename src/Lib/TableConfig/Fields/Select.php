<?php

namespace Kluverp\Pcmn\Lib\TableConfig\Fields;

class Select extends BaseField
{
    public $type = 'select';
    public $options = null; // "Ja,1,ffffff|Nee,0,ff00ee", // if left out, source comes from DB table

    public function getOptions()
    {
        return [0 => 'world', 1 => 'foobar', 2 => 'barbaz'];
    }
}