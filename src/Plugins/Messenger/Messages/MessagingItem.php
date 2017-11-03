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
     * @var $timestamp
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
     * @return mixed
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
     * @return array
     */
    public function getPostback()
    {
        return $this->postback;
    }

    /**
     * @return array
     */
    public function getReferral()
    {
        return $this->referral;
    }

    /**
     * @return array
     */
    public function getOptin()
    {
        return $this->optin;
    }

    /**
     * @return array
     */
    public function getAccountLinking()
    {
        return $this->account_linking;
    }

    /**
     * @return array
     */
    public function getDelivery()
    {
        return $this->delivery;
    }
}