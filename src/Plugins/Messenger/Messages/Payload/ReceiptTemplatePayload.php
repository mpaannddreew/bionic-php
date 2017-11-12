<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 1:26 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\Receipt\ReceiptSummary;
use Andre\Bionic\Plugins\Messenger\Messages\Payment\ShippingAddress;

class ReceiptTemplatePayload extends AbstractTemplatePayload
{
    /**
     * @var string $recipient_name
     */
    protected $recipient_name;

    /**
     * @var string $order_number
     */
    protected $order_number;

    /**
     * @var string $currency
     */
    protected $currency;

    /**
     * @var string $payment_method
     */
    protected $payment_method;

    /**
     * @var string $order_url
     */
    protected $order_url;

    /**
     * @var string $timestamp
     */
    protected $timestamp;

    /**
     * @var array $address
     */
    protected $address = [];

    /**
     * @var array $summary
     */
    protected $summary = [];

    /**
     * @var array $adjustments
     */
    protected $adjustments = [];

    /**
     * @var array $elements
     */
    protected $elements = [];

    /**
     * set template type
     */
    protected function setTemplateType()
    {
        $this->template_type = self::RECEIPT;
    }

    /**
     * get recipient name
     *
     * @return string
     */
    public function getRecipientName()
    {
        return $this->recipient_name;
    }

    /**
     * set recipient name
     *
     * @param string $recipient_name
     * @return $this
     */
    public function setRecipientName($recipient_name)
    {
        $this->recipient_name = $recipient_name;
        $this->data['recipient_name'] = $this->getRecipientName();
        return $this;
    }

    /**
     * get order number
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->order_number;
    }

    /**
     * set order number
     *
     * @param string $order_number
     * @return $this
     */
    public function setOrderNumber($order_number)
    {
        $this->order_number = $order_number;
        $this->data['order_number'] = $this->getOrderNumber();
        return $this;
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
        $this->data['currency'] = $this->getCurrency();
        return $this;
    }

    /**
     * get payment method
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * set payment method
     *
     * @param string $payment_method
     * @return $this
     */
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
        $this->data['payment_method'] = $this->getPaymentMethod();
        return $this;
    }

    /**
     * get order url
     *
     * @return string
     */
    public function getOrderUrl()
    {
        return $this->order_url;
    }

    /**
     * set order url
     *
     * @param string $order_url
     * @return $this
     */
    public function setOrderUrl($order_url)
    {
        $this->order_url = $order_url;
        $this->data['order_url'] = $this->getOrderUrl();
        return $this;
    }

    /**
     * get timestamp
     *
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * set timestamp
     *
     * @param string $timestamp
     * @return $this
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        $this->data['timestamp'] = $this->getTimestamp();
        return $this;
    }

    /**
     * get address
     *
     * @return ShippingAddress|null
     */
    public function getAddress()
    {
        if ($this->address)
            return ShippingAddress::create($this->address);

        return null;
    }

    /**
     * set address
     *
     * @param $address
     * @return $this
     */
    public function setAddress(ShippingAddress $address)
    {
        $this->address = $address->toArray();
        $this->data['address'] = $this->getAddress()->toArray();
        return $this;
    }

    /**
     * get summary
     *
     * @return ReceiptSummary|null
     */
    public function getSummary()
    {
        if ($this->summary)
            return ReceiptSummary::create($this->summary);

        return null;
    }

    /**
     * set summary
     *
     * @param $summary
     * @return $this
     */
    public function setSummary(ReceiptSummary $summary)
    {
        $this->summary = $summary->toArray();
        $this->data['summary'] = $this->getSummary()->toArray();
        return $this;
    }

    /**
     * get adjustments
     *
     * @return array
     */
    public function getAdjustments()
    {
        return $this->adjustments;
    }

    /**
     * set adjustments
     *
     * @param array $adjustments
     * @return $this
     */
    public function setAdjustments($adjustments = [])
    {
        foreach ($adjustments as $adjustment){
            array_push($this->adjustments, $adjustment->toArray());
        }
        $this->data['adjustments'] = $this->getAdjustments();
        return $this;
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * set element
     *
     * @param array $elements
     * @return $this
     */
    public function setElements($elements)
    {
        foreach ($elements as $element){
            array_push($this->elements, $element->toArray());
        }
        $this->data['elements'] = $this->getElements();
        return $this;
    }
}