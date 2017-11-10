<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 11:53 AM
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

class MessagingItem extends AbstractMessage
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
     * @var array $postback
     */
    protected $postback = [];

    /**
     * @var array $referral
     */
    protected $referral = [];

    /**
     * @var array $optin
     */
    protected $optin = [];

    /**
     * @var array $account_linking
     */
    protected $account_linking = [];

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
     * @return Sender
     */
    public function getSender()
    {
        return Sender::create($this->sender);
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
     * get postback
     *
     * @return PostBack|null
     */
    public function getPostback()
    {
        if ($this->postback)
            return PostBack::create($this->postback);

        return null;
    }

    /**
     * get referral
     *
     * @return Referral|null
     */
    public function getReferral()
    {
        if ($this->referral)
            return Referral::create($this->referral);

        return null;
    }

    /**
     * get optin
     *
     * @return Optin|null
     */
    public function getOptin()
    {
        if ($this->optin)
            return Optin::create($this->optin);

        return null;
    }

    /**
     * get account linking
     *
     * @return AccountLinking|null
     */
    public function getAccountLinking()
    {
        if ($this->account_linking)
            return AccountLinking::create($this->account_linking);

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