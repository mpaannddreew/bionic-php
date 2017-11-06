<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 7:08 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\AbstractMessage;

class TemplateElement extends AbstractMessage
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $subtitle
     */
    protected $subtitle;

    /**
     * @var string $image_url
     */
    protected $image_url;

    /**
     * @var array $buttons
     */
    protected $buttons = [];

    /**
     * @var array $default_action
     */
    protected $default_action = [];

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->data['title'] = $this->getTitle();
        return $this;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     * @return $this
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        $this->data['subtitle'] = $this->getSubtitle();
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * @param string $image_url
     * @return $this
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
        $this->data['image_url'] = $this->getImageUrl();
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

    /**
     * @return array
     */
    public function getDefaultAction()
    {
        return $this->default_action;
    }

    /**
     * @param array $default_action
     * @return $this
     */
    public function setDefaultAction($default_action)
    {
        $this->default_action = $default_action;
        $this->data['default_action'] = $this->getDefaultAction();
        return $this;
    }


}