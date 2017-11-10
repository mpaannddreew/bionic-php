<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 1:29 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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