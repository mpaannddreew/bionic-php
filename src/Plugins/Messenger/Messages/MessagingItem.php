<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 11:53 AM
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
     * @return Sender
     */
    public function getSender()
    {
        return new Sender($this->sender);
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return new Recipient($this->recipient);
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return Message|null
     */
    public function getMessage()
    {
        if ($this->message)
            return new Message($this->message);

        return null;
    }

    /**
     * @return PostBack|null
     */
    public function getPostback()
    {
        if ($this->postback)
            return new PostBack($this->postback);

        return null;
    }

    /**
     * @return Referral|null
     */
    public function getReferral()
    {
        if ($this->referral)
            return new Referral($this->referral);

        return null;
    }

    /**
     * @return Optin|null
     */
    public function getOptin()
    {
        if ($this->optin)
            return new Optin($this->optin);

        return null;
    }

    /**
     * @return AccountLinking|null
     */
    public function getAccountLinking()
    {
        if ($this->account_linking)
            return new AccountLinking($this->account_linking);

        return null;
    }

    /**
     * @return Delivery|null
     */
    public function getDelivery()
    {
        if ($this->delivery)
            return new Delivery($this->delivery);

        return null;
    }

    /**
     * @return Read|null
     */
    public function getRead()
    {
        if ($this->delivery)
            return new Read($this->read);

        return null;
    }
}