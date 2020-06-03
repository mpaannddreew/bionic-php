<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:32 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


use Andre\Bionic\Plugins\Telegram\PhotoSize;

class Document extends File
{
    /**
     * @var array $thumb
     */
    protected $thumb = [];

    /**
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @var string $mime_type
     */
    protected $mime_type;

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
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }
}