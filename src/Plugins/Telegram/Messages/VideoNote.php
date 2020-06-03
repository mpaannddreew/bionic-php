<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:40 PM
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