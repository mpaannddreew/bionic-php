<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 10:12 PM
 */

namespace Andre\Bionic\Plugins\Viber\Messages;


class Url extends ViberMessage
{
    /**
     * @var string $media
     */
    protected $media;

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::URL;
    }
}