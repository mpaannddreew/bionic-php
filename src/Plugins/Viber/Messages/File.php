<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 10:01 PM
 */

namespace Andre\Bionic\Plugins\Viber\Messages;



class File extends ViberMessage
{
    /**
     * @var string $media
     */
    protected $media;

    /**
     * @var int $size
     */
    protected $size;

    /**
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::FILE;
    }
}