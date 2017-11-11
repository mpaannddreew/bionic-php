<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 2:46 PM
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

class CheckoutUpdate extends AbstractMessage
{
    /**
     * @var string $payload
     */
    protected $payload;

    /**
     * @var array $shipping_address
     */
    protected $shipping_address = [];

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
     * get shipping address
     *
     * @return ShippingAddress
     */
    public function getShippingAddress()
    {
        return ShippingAddress::create($this->shipping_address);
    }
}