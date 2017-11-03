<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 1:36 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;

class QuickReply extends AbstractMessage
{
    /**
     * @var string $payload
     */
    protected $payload;

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }
}