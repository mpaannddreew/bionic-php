<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 9:54 PM
 */

namespace Andre\Bionic\Plugins\Viber\Messages;


class Image extends Text
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
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::PICTURE;
    }
}