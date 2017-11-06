<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 4:23 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;



class Audio extends AbstractAttachment
{
    /**
     * set type
     */
    protected function setType()
    {
        $this->type = self::AUDIO;
    }
}