<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 9:57 PM
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