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
    protected function setType()
    {
        $this->type = self::LOCATION;
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
     * get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * get location payload
     *
     * @return LocationPayLoad
     */
    public function getPayload()
    {
        return LocationPayLoad::create($this->payload);
    }
}