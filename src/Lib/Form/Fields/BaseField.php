<?php

namespace Kluverp\Pcmn\Lib\Form\Fields;

use Kluverp\Pcmn\Lib\Form\Fields\FieldOption;

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

    /**
     * The form value.
     *
     * @var null
     */
    protected $value = null;

    /**
     * Input type.
     *
     * @var string
     */
    protected $type = 'text';

    protected $view = null;

    /**
     * BaseField constructor.
     * @param $name
     * @param $config
     * @param $value
     */
    public function __construct($name, $config, $value)
    {
        $this->name = $name;
        $this->config = $config;
        $this->value = $value;
    }

    /**
     * Returns the view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function html()
    {
        return view($this->getView(), $this->getViewData());
    }

    /**
     * Returns the ID attr.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getName();
    }

    /**
     * Returns the field name.
     *
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the label.
     *
     * @return string
     */
    public function getLabel()
    {
        if (isset($this->config['label'])) {
            return __($this->config['label']);
        }
        return '&lt;missing label&gt;';
    }

    public function config($key)
    {
        return array_get($this->config, $key);
    }

    /**
     * Returns the placeholder.
     *
     * @return string
     */
    public function getPlaceholder()
    {
        if (isset($this->config['placeholder'])) {
            return $this->config['placeholder'];
        }
        return $this->getLabel();
    }

    /**
     * Returns the form field value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return old($this->getName(), $this->value);
    }

    public function getStorageValue()
    {

    }


    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns the input type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the Fields' view path based on the Class' name.
     *
     * @return string
     */
    protected function getView()
    {
        if ($this->view) {
            return 'pcmn::content.form.fields.' . snake_case(lcfirst($this->view));
        }

        return 'pcmn::content.form.fields.' . snake_case(lcfirst(class_basename(get_class($this))));
    }

    /**
     * Return data array for view.
     *
     * @return array
     */
    protected function getViewData()
    {
        return [
            'id' => $this->getId(),
            'label' => $this->getLabel(),
            'attr' => $this->getAttributeStr(),
            'helpText' => $this->getHelpText(),
            'name' => $this->getName(),
            'prepend' => $this->config('prepend'),
            'append' => $this->config('append')
        ];
    }

    /**
     * Returns the attribute string for use in view.
     *
     * @return string
     */
    protected function getAttributeStr()
    {
        $str = '';
        foreach ($this->getAttributes() as $key => $value) {
            $str .= sprintf(' %s="%s"', $key, $value);
        }

        return $str;
    }

    /**
     * Returns the fields' attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attr = [
            'class' => $this->getClass(),
            'id' => $this->getId(),
            'name' => $this->getName(),
            'placeholder' => $this->getPlaceholder(),
            'value' => $this->getValue(),
            'type' => $this->getType(),
        ];

        if (isset($this->config['attr'])) {
            $attr = array_merge($this->config['attr'], $attr);
        }

        return $attr;
    }

    /**
     * Returns the classnames for input.
     *
     * @return string
     */
    public function getClass()
    {
        $classes = ['form-control'];
        if ($errors = session()->get('errors')) {
            if ($errors->has($this->getName())) {
                $classes[] = 'is-invalid';
            }
        }

        return implode($classes, ' ');
    }

    /**
     * Returns the field's helptext if set.
     *
     * @return bool
     */
    public function getHelpText()
    {
        if (!empty($this->config['help_text'])) {
            return $this->config['help_text'];
        }

        return false;
    }

    public function getRules()
    {
        return array_get($this->config, 'rules');
    }
}
