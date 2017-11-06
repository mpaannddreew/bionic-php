<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 6:08 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


class GenericTemplatePayload extends AbstractTemplatePayload
{
    /**
     * @var array $elements
     */
    protected $elements = [];

    /**
     * set template type
     */
    public function setTemplateType()
    {
        $this->template_type = self::GENERIC;
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
}