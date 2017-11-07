<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 5:33 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Coordinates;

class LocationPayLoad extends AbstractMessage
{
    /**
     * @var array $coordinates
     */
    protected $coordinates = [];

    /**
     * @return Coordinates|null
     */
    public function getCoordinates()
    {
        if ($this->coordinates)
            return new Coordinates($this->coordinates);

        return null;
    }
}