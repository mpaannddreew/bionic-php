<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 4:25 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;



class Video extends AbstractAttachment
{

    /**
     * set type
     */
    public function setType()
    {
        $this->type = self::VIDEO;
    }
}