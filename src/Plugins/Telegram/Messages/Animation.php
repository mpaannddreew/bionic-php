<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


class Animation extends Video
{
    /**
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }
}