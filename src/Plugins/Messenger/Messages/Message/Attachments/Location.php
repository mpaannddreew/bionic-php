<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 4:23 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;



use Andre\Bionic\Plugins\Messenger\Messages\Payload\LocationPayLoad;

class Location extends AbstractAttachment
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * set type
     */
    public function setType()
    {
        $this->type = self::LOCATION;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return LocationPayLoad
     */
    public function getPayload()
    {
        return new LocationPayLoad($this->payload);
    }
}