<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 12:02 PM
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

class ShippingAddress extends AbstractMessage
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $street1
     */
    protected $street1;

    /**
     * @var string $street2
     */
    protected $street2;

    /**
     * @var string $city
     */
    protected $city;

    /**
     * @var string $state
     */
    protected $state;

    /**
     * @var string $country
     */
    protected $country;

    /**
     * @var string $postal_code
     */
    protected $postal_code;

    /**
     * get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

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
     * get street 1
     *
     * @return string
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * get street 2
     *
     * @return string
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * get postal code
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }
}