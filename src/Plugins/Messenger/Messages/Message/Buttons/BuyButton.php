<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 11:01 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class BuyButton extends PostBackButton
{
    /**
     * @var array $payment_summary
     */
    protected $payment_summary = [];

    /**
     * @var string $currency
     */
    protected $currency;

    /**
     * @var string $payment_type
     */
    protected $payment_type;

    /**
     * @var bool $is_test_payment
     */
    protected $is_test_payment = False;

    /**
     * @var string $merchant_name
     */
    protected $merchant_name;

    /**
     * @var array $requested_user_info
     */
    protected $requested_user_info = [];

    /**
     * @var array $price_list
     */
    protected $price_list = [];

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::PAYMENT;
    }

    /**
     * get payment summary
     *
     * @return array
     */
    public function getPaymentSummary()
    {
        return $this->payment_summary;
    }

    /**
     * get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * set currency
     *
     * @param string $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        $this->payment_summary['currency'] = $this->getCurrency();
        $this->data['payment_summary'] = $this->getPaymentSummary();
        return $this;
    }

    /**
     * get payment type
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * set payment type
     *
     * @param string $payment_type
     * @return $this
     */
    public function setPaymentType($payment_type)
    {
        $this->payment_type = $payment_type;
        $this->payment_summary['payment_type'] = $this->getPaymentType();
        $this->data['payment_summary'] = $this->getPaymentSummary();
        return $this;
    }

    /**
     * is test payment
     *
     * @return bool
     */
    public function isTestPayment()
    {
        return $this->is_test_payment;
    }

    /**
     * determine if is test payment
     *
     * @param bool $is_test_payment
     * @return $this
     */
    public function setIsTestPayment($is_test_payment)
    {
        $this->is_test_payment = $is_test_payment;
        $this->payment_summary['is_test_payment'] = $this->isTestPayment();
        $this->data['payment_summary'] = $this->getPaymentSummary();
        return $this;
    }

    /**
     * get Merchant name
     *
     * @return string
     */
    public function getMerchantName()
    {
        return $this->merchant_name;
    }

    /**
     * set merchant name
     *
     * @param string $merchant_name
     * @return $this
     */
    public function setMerchantName($merchant_name)
    {
        $this->merchant_name = $merchant_name;
        $this->payment_summary['merchant_name'] = $this->getMerchantName();
        $this->data['payment_summary'] = $this->getPaymentSummary();
        return $this;
    }

    /**
     * get requested user info
     *
     * @return array
     */
    public function getRequestedUserInfo()
    {
        return $this->requested_user_info;
    }

    /**
     * set requested user info
     *
     * @param array $requested_user_info
     * @return $this
     */
    public function setRequestedUserInfo($requested_user_info = [])
    {
        $this->requested_user_info = $requested_user_info;
        $this->payment_summary['requested_user_info'] = $this->getRequestedUserInfo();
        $this->data['payment_summary'] = $this->getPaymentSummary();
        return $this;
    }

    /**
     * get price list
     *
     * @return array
     */
    public function getPriceList()
    {
        return $this->price_list;
    }

    /**
     * set price list
     *
     * @param array $price_list
     * @return $this
     */
    public function setPriceList($price_list = [])
    {
        $this->price_list = $price_list;
        $this->payment_summary['price_list'] = $this->getPriceList();
        $this->data['payment_summary'] = $this->getPaymentSummary();
        return $this;
    }
}