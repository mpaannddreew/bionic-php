<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 16/06/2021
 * Time: 23:37
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;


class StoryMention extends AbstractAttachment
{
    /**
     * set type
     */
    protected function setType()
    {
        $this->type = self::STORY_MENTION;
    }
}