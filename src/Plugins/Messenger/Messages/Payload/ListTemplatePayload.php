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


class ListTemplatePayload extends GenericTemplatePayload
{
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
        foreach ($buttons as $button){
            array_push($this->buttons, $button->toArray());
        }
        $this->data['buttons'] = $this->getButtons();
        return $this;
    }
}