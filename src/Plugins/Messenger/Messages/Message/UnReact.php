<?php

/**
 * Created by PhpStorm.
 * User: andre
 * Date: 17/06/2021
 * Time: 12:21
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


class UnReact extends AbstractReaction
{
    /**
     * set sender action
     */
    protected function setSenderAction()
    {
        $this->sender_action = self::UNREACT;
    }
}