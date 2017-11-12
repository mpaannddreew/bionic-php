<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 3:47 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\Receipt;


use Andre\Bionic\AbstractMessage;

class ReceiptSummary extends AbstractMessage
{
    /**
     * @var float $subtotal
     */
    protected $subtotal;

    /**
     * @var float $shipping_cost
     */
    protected $shipping_cost;

    /**
     * @var float $total_tax
     */
    protected $total_tax;

    /**
     * @var float $total_cost
     */
    protected $total_cost;

    /**
     * get subtotal
     *
     * @return float
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * set subtotal
     *
     * @param float $subtotal
     * @return $this
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
        $this->data['subtotal'] = $this->getSubtotal();
        return $this;
    }

    /**
     * get shipping cost
     *
     * @return float
     */
    public function getShippingCost()
    {
        return $this->shipping_cost;
    }

    /**
     * set shipping cost
     *
     * @param float $shipping_cost
     * @return $this
     */
    public function setShippingCost($shipping_cost)
    {
        $this->shipping_cost = $shipping_cost;
        $this->data['shipping_cost'] = $this->getShippingCost();
        return $this;
    }

    /**
     * get total tax
     *
     * @return float
     */
    public function getTotalTax()
    {
        return $this->total_tax;
    }

    /**
     * set total tax
     *
     * @param float $total_tax
     * @return $this
     */
    public function setTotalTax($total_tax)
    {
        $this->total_tax = $total_tax;
        $this->data['total_tax'] = $this->getTotalTax();
        return $this;
    }

    /**
     * get total cost
     *
     * @return float
     */
    public function getTotalCost()
    {
        return $this->total_cost;
    }

    /**
     * set total cost
     *
     * @param float $total_cost
     * @return $this
     */
    public function setTotalCost($total_cost)
    {
        $this->total_cost = $total_cost;
        $this->data['total_cost'] = $this->getTotalCost();
        return $this;
    }
}