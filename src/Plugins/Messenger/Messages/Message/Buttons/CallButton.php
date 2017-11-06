<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:17 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class CallButton extends AbstractButton
{

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $payload
     */
    protected $payload;

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::PHONE_NUMBER;
    }

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
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        $this->data['payload'] = $this->getPayload();
        return $this;
    }


}