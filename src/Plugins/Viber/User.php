<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 8:48 PM
 */

namespace Andre\Bionic\Plugins\Viber;


use Andre\Bionic\AbstractMessage;

class User extends AbstractMessage
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $avatar;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var int
     */
    protected $api_version;

    /**
     * @var string $viber_version
     */
    protected $viber_version;

    /**
     * @var int $mcc
     */
    protected $mcc;

    /**
     * @var int $mnc
     */
    protected $mnc;

    /**
     * @var string $device_type
     */
    protected $device_type;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return int
     */
    public function getApiVersion()
    {
        return $this->api_version;
    }

    /**
     * @return string
     */
    public function getViberVersion()
    {
        return $this->viber_version;
    }

    /**
     * @return int
     */
    public function getMcc()
    {
        return $this->mcc;
    }

    /**
     * @return int
     */
    public function getMnc()
    {
        return $this->mnc;
    }

    /**
     * @return string
     */
    public function getDeviceType()
    {
        return $this->device_type;
    }
}