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
    protected function setTemplateType()
    {
        $this->template_type = self::BUTTON;
    }

    /**
     * get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * set text
     *
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