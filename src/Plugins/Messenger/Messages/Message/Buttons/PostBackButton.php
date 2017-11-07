<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:10 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class PostBackButton extends AbstractButton
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
        $this->type = self::POST_BACK;
    }

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
     * get payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * set payload
     *
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