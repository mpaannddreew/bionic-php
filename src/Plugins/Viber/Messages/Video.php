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



class Video extends ViberMessage
{
    /**
     * @var string $media
     */
    protected $media;

    /**
     * @var string $thumbnail
     */
    protected $thumbnail;

    /**
     * @var int $size
     */
    protected $size;

    /**
     * @var int $duration
     */
    protected $duration;

    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::VIDEO;
    }
}