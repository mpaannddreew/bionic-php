<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 6:08 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


class ListTemplatePayload extends AbstractTemplatePayload
{
    /**
     * @var array $elements
     */
    protected $elements = [];

    /**
     * @var string $top_element_style
     */
    protected $top_element_style;

    /**
     * @var array $buttons
     */
    protected $buttons = [];

    /***
     * set template type
     */
    protected function setTemplateType()
    {
        $this->template_type = self::LIST_;
    }

    /**
     * get elements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * set elements
     *
     * @param array $elements
     * @return $this
     */
    public function setElements($elements)
    {
        $this->elements = $elements;
        $this->data['elements'] = $this->getElements();
        return $this;
    }

    /**
     * get top element style
     *
     * @return string
     */
    public function getTopElementStyle()
    {
        return $this->top_element_style;
    }

    /**
     * set top element style
     *
     * @param string $top_element_style
     * @return $this
     */
    public function setTopElementStyle($top_element_style)
    {
        $this->top_element_style = $top_element_style;
        $this->data['top_element_style'] = $this->getTopElementStyle();
        return $this;
    }

    /**
     * get buttons
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * set buttons
     *
     * @param array $buttons
     * @return $this
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;
        $this->data['buttons'] = $this->getButtons();
        return $this;
    }
}