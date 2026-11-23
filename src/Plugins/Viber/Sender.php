<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Viber;


use Andre\Bionic\AbstractMessage;

class Sender extends AbstractMessage
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $avatar
     */
    protected $avatar;
}