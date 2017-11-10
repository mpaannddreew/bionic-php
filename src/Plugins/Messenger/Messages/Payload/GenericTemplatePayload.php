<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 6:08 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
    protected function setTemplateType()
    {
        $this->template_type = self::GENERIC;
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
}