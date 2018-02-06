<?php

namespace Kluverp\Pcmn\Lib\Form;


class DataHandler
{
    /**
     * Form data.
     *
     * @var array
     */
    private $data = [];

    /**
     * DataHandler constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Returns all form data as one flat array. This flattens array fields as comma separated strings.
     *
     * @return array
     */
    public function getFlatData()
    {
        foreach($this->data as &$d) {
            if(is_array($d)) {
                $d = implode(',', $d);
            }
        }

        return $this->data;
    }
}