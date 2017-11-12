<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 7:08 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons\AbstractButton;

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
     * @var string $currency
     */
    protected $currency;

    /**
     * @var int $quantity
     */
    protected $quantity;

    /**
     * @var int $price
     */
    protected $price;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var string $media_type
     */
    protected $media_type;

    /**
     * @var array $buttons
     */
    protected $buttons = [];

    /**
     * @var array $default_action
     */
    protected $default_action = [];

    /**
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * set title
     *
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
     * get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * set subtitle
     *
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
     * get image url
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * set image url
     *
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
     * get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * set image url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $this->data['url'] = $this->getUrl();
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

    /**
     * get default action
     *
     * @return array
     */
    public function getDefaultAction()
    {
        return $this->default_action;
    }

    /**
     * set default action
     *
     * @param AbstractButton $default_action
     * @return $this
     */
    public function setDefaultAction(AbstractButton $default_action)
    {
        $this->default_action = $default_action->toArray();
        $this->data['default_action'] = $this->getDefaultAction();
        return $this;
    }

    /**
     * get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * set quantity
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        $this->data['currency'] = $this->getCurrency();
        return $this;
    }

    /**
     * get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * set quantity
     *
     * @param int $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->data['quantity'] = $this->getQuantity();
        return $this;
    }

    /**
     * get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * set price
     *
     * @param int $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->data['price'] = $this->getPrice();
        return $this;
    }

    /**
     * get media type
     *
     * @return string
     */
    public function getMediaType()
    {
        return $this->media_type;
    }

    /**
     * set medi type
     *
     * @param string $media_type
     * @return $this
     */
    public function setMediaType($media_type)
    {
        $this->media_type = $media_type;
        $this->data['media_type'] = $this->getMediaType();
        return $this;
    }
}