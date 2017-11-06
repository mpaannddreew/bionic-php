<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 1:29 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


class TypingOff extends AbstractSenderAction
{

    /**
     * set sender action
     */
    protected function setSenderAction()
    {
        $this->sender_action = self::TYPING_OFF;
    }
}