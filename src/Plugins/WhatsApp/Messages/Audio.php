<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 10:00 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;


class Audio extends Media
{
    /**
     * @var boolean $voice
     */
    protected $voice;

    /**
     * @return bool
     */
    public function isVoice()
    {
        return $this->voice;
    }
}