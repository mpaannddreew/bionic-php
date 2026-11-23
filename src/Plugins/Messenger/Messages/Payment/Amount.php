<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payment;


use Andre\Bionic\AbstractMessage;

class Amount extends AbstractMessage
{
    /**
     * @var string $currency
     */
    protected $currency;

    /**
     * @var string $amount
     */
    protected $amount;

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
     * get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }
}