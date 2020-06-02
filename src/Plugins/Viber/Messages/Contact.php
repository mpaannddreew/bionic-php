<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 10:03 PM
 */

namespace Andre\Bionic\Plugins\Viber\Messages;



class Contact extends ViberMessage
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $phone_number
     */
    protected $phone_number;

    /**
     * @var string $avatar
     */
    protected $avatar;

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
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::CONTACT;
    }
}