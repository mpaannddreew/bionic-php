<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 2:58 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;

class Coordinates extends AbstractMessage
{
    /**
     * @var float $lat
     */
    protected $lat;

    /**
     * @var float $long
     */
    protected $long;

    /**
     * get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * get long
     *
     * @return float
     */
    public function getLong()
    {
        return $this->long;
    }
}