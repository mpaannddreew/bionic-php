<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
