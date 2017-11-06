<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 6:08 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


class ButtonTemplatePayload extends AbstractTemplatePayload
{
    /**
     * @var string $text
     */
    protected $text;

    /**
     * @var array $buttons
     */
    protected $buttons = [];

    /**
     * set template type
     */
    public function setTemplateType()
    {
        $this->template_type = self::BUTTON;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->data['text'] = $this->getText();
        return $this;
    }

    /**
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
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