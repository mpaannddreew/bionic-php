<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 11:38 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payment;


class Payment extends AbstractCheckout
{
    /**
     * @var array $payment_credential
     */
    protected $payment_credential = [];

    /**
     * @var string $shipping_option_id
     */
    protected $shipping_option_id;

    /**
     * get payment credentials
     *
     * @return PaymentCredential
     */
    public function getPaymentCredential()
    {
        return PaymentCredential::create($this->payment_credential);
    }

    /**
     * get shipping option id
     *
     * @return string
     */
    public function getShippingOptionId()
    {
        return $this->shipping_option_id;
    }
}