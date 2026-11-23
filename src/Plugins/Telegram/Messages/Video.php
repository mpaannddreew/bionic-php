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

class Video extends PhotoSize
{
    /**
     * @var int $duration
     */
    protected $duration;

    /**
     * @var array $thumb
     */
    protected $thumb = [];

    /**
     * @var string $mime_type
     */
    protected $mime_type;

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return PhotoSize|null
     */
    public function getThumb()
    {
        if ($this->thumb) {
            return PhotoSize::create($this->thumb);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }
}
