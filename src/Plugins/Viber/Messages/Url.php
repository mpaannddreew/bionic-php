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

class Url extends ViberMessage
{
    /**
     * @var string $media
     */
    protected $media;

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::URL;
    }
}
