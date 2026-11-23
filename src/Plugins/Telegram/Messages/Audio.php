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

class Audio extends File
{
    /**
     * @var int $duration
     */
    protected $duration;

    /**
     * @var string $performer
     */
    protected $performer;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $mime_type
     */
    protected $mime_type;

    /**
     * @var array $thumb
     */
    protected $thumb = [];

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getPerformer()
    {
        return $this->performer;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
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