<?php

namespace Kluverp\Pcmn\Lib\Form;


use Kluverp\Pcmn\Lib\TableConfig;

class FormData
{
    /**
     * Form data.
     *
     * @var array
     */
    private $data = [];

    /**
     * The config object.
     *
     * @var TableConfig|null
     */
    private $config = null;

    /**
     * DataHandler constructor.
     * @param TableConfig $config
     * @param $data
     */
    public function __construct(TableConfig $config, $data)
    {
        $this->config = $config;
        $this->data = $data;
    }

    /**
     * Returns all form data as one flat array. This flattens array fields as comma separated strings.
     *
     * @return array
     */
    public function getForStorage()
    {
        $data = [];

        foreach ($this->config->getFields() as $key => $params) {

            // skip field if flag is set
            if (!empty($params['skip'])) {
                continue;
            }

            if($params['type'] == 'slug')
            {
                $data[$key . '_slug'] = str_slug($this->getStringData($key));
            }

            // set field to null, if not in POSTed data array (checkboxes)
            $this->nullIfOmitted($key, $this->data);

            // get data as string by flattening arrays
            $data[$key] = $this->getStringData($key);
        }

        return $data;
    }

    /**
     * If field is ommitted in POST, then we default the field as null.
     *
     * @param $key
     * @param $data
     * @return null
     */
    private function nullIfOmitted($key, &$data)
    {
        if (!array_key_exists($key, $this->data)) {
            return $data[$key] = null;
        }

        return true;
    }

    /**
     * Returns value of given field as string data.
     * This means array values (checkboxes, multiselect) are flattened.
     *
     * @param $key
     * @return mixed|string
     */
    private function getStringData($key)
    {
        // if posted value is an array (checkbox) implode to string
        if (is_array($this->data[$key])) {
            return implode(',', $this->data[$key]);
        }

        return $this->data[$key];
    }
}