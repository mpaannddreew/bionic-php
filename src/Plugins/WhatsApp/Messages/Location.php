<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 9:34 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;


use Andre\Bionic\AbstractMessage;

class Location extends AbstractMessage
{
    protected $address;

    protected $latitude;

    protected $longitude;

    protected $name;

    protected $url;

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}