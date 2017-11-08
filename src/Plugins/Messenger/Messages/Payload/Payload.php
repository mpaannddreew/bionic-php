<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 2:24 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Coordinates;

class Payload extends AbstractMessage
{
    /**
     * @var string $url
     */
    protected $url;

    /**
     * get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}