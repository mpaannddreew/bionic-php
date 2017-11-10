<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 6:50 PM
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
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * get payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
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
}