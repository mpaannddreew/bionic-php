<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:46 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


class Voice extends File
{
    /**
     * @var int $duration
     */
    protected $duration;

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
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }
}