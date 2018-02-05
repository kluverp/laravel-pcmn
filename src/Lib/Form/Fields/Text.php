<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;

class Text extends BaseField
{
    /**
     * Radio type.
     *
     * @var string
     */
    protected $type = 'text';

    /**
     * Default rows when not defined.
     *
     * @var int
     */
    private $defaultRows = 5;

    /**
     * Default cols when not defined.
     *
     * @var int
     */
    private $defaultCols = 20;

    /**
     * Returns the fields' attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return [
            'class' => 'form-control',
            'id' => $this->getId(),
            'name' => $this->getName(),
            'placeholder' => $this->getPlaceholder(),
            'rows' => $this->getRows(),
            'cols' => $this->getCols()
        ];
    }

    /**
     * Return data array for view.
     *
     * @return array
     */
    protected function getViewData()
    {
        // add the value to view data
        return array_merge(parent::getViewData(), [
            'value' => $this->getValue()
        ]);
    }

    /**
     * Returns # of rows from config, or default.
     *
     * @return int
     */
    private function getRows()
    {
        if (!empty($this->config['rows'])) {
            return $this->config['rows'];
        }

        return $this->defaultRows;
    }

    /**
     * Returns # of cols from config, or default.
     *
     * @return int
     */
    private function getCols()
    {
        if (!empty($this->config['cols'])) {
            return $this->config['cols'];
        }

        return $this->defaultCols;
    }

}
