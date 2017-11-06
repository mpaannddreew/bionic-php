<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 1:23 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


class MarkSeen extends AbstractSenderAction
{

    /**
     * set sender action
     */
    public function setSenderAction()
    {
        $this->sender_action = self::MARK_SEEN;
    }
}