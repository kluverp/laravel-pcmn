<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;

class BaseField
{
    /**
     * Field name.
     *
     * @var null
     */
    protected $name = null;

    /**
     * Field config.
     *
     * @var null
     */
    protected $config = null;

    protected $data = [];

    /**
     * BaseField constructor.
     * @param $name
     * @param $config
     */
    public function __construct($name, $config)
    {
        $this->name = $name;
        $this->config = $config;
    }

    /**
     * Returns the view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function html()
    {
        return $this->getView($this->config['type'], $this->data);
    }

    /**
     * Returns the Fields' view.
     *
     * @param $view
     * @param $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function getView($view, $data)
    {
        return view('pcmn::content.form.fields.' . $view, $data);
    }
}