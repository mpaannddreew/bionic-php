<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 16/06/2021
 * Time: 23:24
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;


class Share extends AbstractAttachment
{
    /**
     * set type
     */
    protected function setType()
    {
        $this->type = self::SHARE;
    }
}