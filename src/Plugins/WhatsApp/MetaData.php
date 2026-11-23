<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp;


use Andre\Bionic\AbstractMessage;

class MetaData extends AbstractMessage
{
    /**
     * @var string $display_phone_number
     */
    protected $display_phone_number;

    /**
     * @var string $phone_number_id
     */
    protected $phone_number_id;

    /**
     * @return string
     */
    public function getDisplayPhoneNumber()
    {
        return $this->display_phone_number;
    }

    /**
     * @return string
     */
    public function getPhoneNumberId()
    {
        return $this->phone_number_id;
    }
}