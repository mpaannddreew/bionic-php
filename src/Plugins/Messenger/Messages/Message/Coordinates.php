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
     * @var $lat
     */
    protected $lat;

    /**
     * @var $long
     */
    protected $long;

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return mixed
     */
    public function getLong()
    {
        return $this->long;
    }
}