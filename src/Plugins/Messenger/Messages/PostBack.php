<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 6:50 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;

class PostBack extends AbstractMessage
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $payload
     */
    protected $payload;

    /**
     * @var array $referral
     */
    protected $referral = [];

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
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
}