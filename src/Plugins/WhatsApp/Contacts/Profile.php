<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp\Contacts;


use Andre\Bionic\AbstractMessage;

class Profile extends AbstractMessage
{
    protected $name;

    public function getName() {
        return $this->name;
    }
}