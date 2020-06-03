<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:20 PM
 */

namespace Andre\Bionic\Plugins\Telegram;


use Andre\Bionic\Plugins\Telegram\Messages\File;

class PhotoSize extends File
{

    /**
     * @var int $width
     */
    protected $width;

    /**
     * @var int $height
     */
    protected $height;

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}