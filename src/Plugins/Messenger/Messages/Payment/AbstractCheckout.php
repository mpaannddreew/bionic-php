<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 3:26 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payment;


use Andre\Bionic\AbstractMessage;

abstract class AbstractCheckout extends AbstractMessage
{
    /**
     * @var string $payload
     */
    protected $payload;

    /**
     * @var array $requested_user_info
     */
    protected $requested_user_info = [];

    /**
     * @var array $amount
     */
    protected $amount = [];

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
     * get requested user info
     *
     * @return UserInformation|null
     */
    public function getRequestedUserInfo()
    {
        if ($this->requested_user_info)
            return UserInformation::create($this->requested_user_info);

        return null;
    }

    /**
     * get amount
     *
     * @return Amount
     */
    public function getAmount()
    {
        if ($this->amount)
            return Amount::create($this->amount);

        return null;
    }
}