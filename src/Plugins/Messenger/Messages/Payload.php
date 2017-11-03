<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 2:24 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Coordinates;

class Payload extends AbstractMessage
{
    /**
     * @var $url
     */
    protected $url;

    /**
     * @var array
     */
    protected $coordinates = [];

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

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