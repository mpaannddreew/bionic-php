<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 4:29 PM
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

class ReceiptAdjustment extends AbstractMessage
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var int $amount
     */
    protected $amount;

    /**
     * get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->data['name'] = $this->getName();
        return $this;
    }

    /**
     * get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * set amount
     *
     * @param int $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        $this->data['amount'] = $this->getAmount();
        return $this;
    }
}