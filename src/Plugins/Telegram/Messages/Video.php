<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:36 PM
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
     * @return PhotoSize
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