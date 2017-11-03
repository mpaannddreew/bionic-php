<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 1:52 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Payload;

abstract class AbstractAttachment extends AbstractMessage
{
    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var array $payload
     */
    protected $payload = [];

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Payload
     */
    public function getPayload()
    {
        return new Payload($this->payload);
    }
}