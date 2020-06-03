<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/3/20
 * Time: 7:52 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


use Andre\Bionic\AbstractMessage;

class Location extends AbstractMessage
{
    /**
     * @var float $longitude
     */
    protected $longitude;

    /**
     * @var float $latitude
     */
    protected $latitude;

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}