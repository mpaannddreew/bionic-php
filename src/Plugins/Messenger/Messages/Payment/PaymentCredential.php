<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 12:21 PM
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

class PaymentCredential extends  AbstractMessage
{
    /**
     * @var string $provider_type
     */
    protected $provider_type;

    /**
     * @var string $charge_id
     */
    protected $charge_id;

    /**
     * @var string $tokenized_card
     */
    protected $tokenized_card;

    /**
     * @var string $tokenized_cvv
     */
    protected $tokenized_cvv;

    /**
     * @var string $token_expiry_month
     */
    protected $token_expiry_month;

    /**
     * @var string $token_expiry_year
     */
    protected $token_expiry_year;

    /**
     * @var string $fb_payment_id
     */
    protected $fb_payment_id;

    /**
     * get provider type
     *
     * @return string
     */
    public function getProviderType()
    {
        return $this->provider_type;
    }

    /**
     * get charged id
     *
     * @return string
     */
    public function getChargeId()
    {
        return $this->charge_id;
    }

    /**
     * get tokenized card
     *
     * @return string
     */
    public function getTokenizedCard()
    {
        return $this->tokenized_card;
    }

    /**
     * get tokenized cvv
     *
     * @return string
     */
    public function getTokenizedCvv()
    {
        return $this->tokenized_cvv;
    }

    /**
     * token expiry
     *
     * @return string
     */
    public function getTokenExpiryMonth()
    {
        return $this->token_expiry_month;
    }

    /**
     * get token expiry year
     *
     * @return string
     */
    public function getTokenExpiryYear()
    {
        return $this->token_expiry_year;
    }

    /**
     * get fb payment id
     *
     * @return string
     */
    public function getFbPaymentId()
    {
        return $this->fb_payment_id;
    }
}