<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 4:02 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Recipient;
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\Sender;

abstract class AbstractChannelItem extends AbstractMessage
{
    /**
     * @var array $sender
     */
    protected $sender = [];

    /**
     * @var array $recipient
     */
    protected $recipient = [];

    /**
     * @var int $timestamp
     */
    protected $timestamp;

    /**
     * @var array $message
     */
    protected $message = [];

    /**
     * @var array $delivery
     */
    protected $delivery = [];

    /**
     * @var array $read
     */
    protected $read = [];

    /**
     * get sender
     *
     * @return Sender|null
     */
    public function getSender()
    {
        if ($this->sender)
            return Sender::create($this->sender);

        return null;
    }

    /**
     * get recipient
     *
     * @return Recipient
     */
    public function getRecipient()
    {
        return Recipient::create($this->recipient);
    }

    /**
     * get timestamp
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * get message
     *
     * @return Message|null
     */
    public function getMessage()
    {
        if ($this->message)
            return Message::create($this->message);

        return null;
    }

    /**
     * get delivery
     *
     * @return Delivery|null
     */
    public function getDelivery()
    {
        if ($this->delivery)
            return Delivery::create($this->delivery);

        return null;
    }

    /**
     * get read
     *
     * @return Read|null
     */
    public function getRead()
    {
        if ($this->read)
            return Read::create($this->read);

        return null;
    }
}