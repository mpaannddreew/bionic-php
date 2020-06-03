<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/3/20
 * Time: 7:55 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


use Andre\Bionic\AbstractMessage;

class Venue extends AbstractMessage
{
    /**
     * @var array $location
     */
    protected $location = [];

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $address
     */
    protected $address;

    /**
     * @var string $foursquare_id
     */
    protected $foursquare_id;

    /**
     * @var string $foursquare_type
     */
    protected $foursquare_type;

    /**
     * @return Location
     */
    public function getLocation()
    {
        return Location::create($this->location);
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getFoursquareId()
    {
        return $this->foursquare_id;
    }

    /**
     * @return string
     */
    public function getFoursquareType()
    {
        return $this->foursquare_type;
    }
}