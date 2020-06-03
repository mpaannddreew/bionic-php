<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 10:08 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


use Andre\Bionic\AbstractMessage;

class Contact extends AbstractMessage
{
    /**
     * @var string $phone_number
     */
    protected $phone_number;

    /**
     * @var string $first_name
     */
    protected $first_name;

    /**
     * @var string $last_name
     */
    protected $last_name;

    /**
     * @var int $user_id
     */
    protected $user_id;

    /**
     * @var string $vcard
     */
    protected $vcard;

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
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getVcard()
    {
        return $this->vcard;
    }
}