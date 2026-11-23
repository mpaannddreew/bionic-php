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

use Andre\Bionic\Plugins\Telegram\PhotoSize;

class VideoNote extends File
{
    /**
     * @var int $length
     */
    protected $length;

    /**
     * @var int $duration
     */
    protected $duration;

    /**
     * @var array $thumb
     */
    protected $thumb = [];

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return PhotoSize
     */
    public function getThumb()
    {
        if ($this->thumb) {
            return PhotoSize::create($this->thumb);
        }

        return null;
    }
}
