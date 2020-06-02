<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 10:05 PM
 */

namespace Andre\Bionic\Plugins\Viber\Messages;


class Location extends ViberMessage
{
    /**
     * @var string $lat
     */
    protected $lat;

    /**
     * @var string $lon
     */
    protected $lon;

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return string
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::LOCATION;
    }
}