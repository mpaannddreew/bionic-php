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
     * @var string $street_1
     */
    protected $street_1;

    /**
     * @var string $street_2
     */
    protected $street_2;

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
     * set id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->data['id'] = $this->getId();
        return $this;
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
     * get street 1
     *
     * @return string
     */
    public function getStreet1()
    {
        return $this->street_1;
    }

    /**
     * set street 1
     *
     * @param string $street_1
     * @return $this
     */
    public function setStreet1($street_1)
    {
        $this->street_1 = $street_1;
        $this->data['street_1'] = $this->getStreet1();
        return $this;
    }

    /**
     * get street 2
     *
     * @return string
     */
    public function getStreet2()
    {
        return $this->street_2;
    }

    /**
     * set street 2
     *
     * @param string $street_2
     * @return $this
     */
    public function setStreet2($street_2)
    {
        $this->street_2 = $street_2;
        $this->data['street_2'] = $this->getStreet2();
        return $this;
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
     * set city
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        $this->data['city'] = $this->getCity();
        return $this;
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
     * set state
     *
     * @param string $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        $this->data['state'] = $this->getState();
        return $this;
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
     * set country
     *
     * @param string $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        $this->data['country'] = $this->getCountry();
        return $this;
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

    /**
     * set postal code
     *
     * @param string $postal_code
     * @return $this
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
        $this->data['postal_code'] = $this->getPostalCode();
        return $this;
    }
}