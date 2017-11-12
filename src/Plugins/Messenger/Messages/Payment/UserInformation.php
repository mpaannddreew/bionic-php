<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 11:57 AM
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

class UserInformation extends AbstractMessage
{
    /**
     * @var array $shipping_address
     */
    protected $shipping_address = [];

    /**
     * @var string $contact_name
     */
    protected $contact_name;

    /**
     * @var string $contact_email
     */
    protected $contact_email;

    /**
     * @var string $contact_phone
     */
    protected $contact_phone;

    /**
     * get shipping address
     *
     * @return ShippingAddress|null
     */
    public function getShippingAddress()
    {
        if ($this->shipping_address)
            return ShippingAddress::create($this->shipping_address);

        return null;
    }

    /**
     * get contact name
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contact_name;
    }

    /**
     * get contact email
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }

    /**
     * get contact phone
     *
     * @return string
     */
    public function getContactPhone()
    {
        return $this->contact_phone;
    }
}