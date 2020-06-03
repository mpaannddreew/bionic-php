<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:24 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


class Animation extends Video
{
    /**
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }
}