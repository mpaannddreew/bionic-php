<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Viber;

use Andre\Bionic\AbstractWebHookEvent;

class ViberWebHookEvent extends AbstractWebHookEvent
{
    /**
     * @var string $event
     */
    protected $event;

    /**
     * @var int $timestamp
     */
    protected $timestamp;

    /**
     * @var int $message_token
     */
    protected $message_token;

    /**
     * @var string $user_id
     */
    protected $user_id;

    /**
     * @var array $user
     */
    protected $user = [];

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var string $context
     */
    protected $context;

    /**
     * @var bool $subscribed
     */
    protected $subscribed;

    /**
     * @var string $desc
     */
    protected $desc;

    /**
     * @var array $sender
     */
    protected $sender = [];

    /**
     * @var array $message
     */
    protected $message = [];

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return int
     */
    public function getMessageToken()
    {
        return $this->message_token;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user) {
            return User::create($this->user);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return bool
     */
    public function isSubscribed()
    {
        return $this->subscribed;
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @return User|null
     */
    public function getSender()
    {
        if ($this->sender) {
            return User::create($this->sender);
        }

        return null;
    }

    /**
     * @return Message|null
     */
    public function getMessage()
    {
        if ($this->message) {
            return Message::create($this->message);
        }

        return null;
    }
}
