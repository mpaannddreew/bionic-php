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
     * set template type
     */
    public function setTemplateType()
    {
        $this->template_type = self::LIST_;
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
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
     * @return string
     */
    public function getTopElementStyle()
    {
        return $this->top_element_style;
    }

    /**
     * @param string $top_element_style
     * @return $this
     */
    public function setTopElementStyle($top_element_style)
    {
        $this->top_element_style = $top_element_style;
        $this->data['top_element_style'] = $this->getTopElementStyle();
        return $this;
    }


}