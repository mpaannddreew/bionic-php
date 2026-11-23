<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;

use Andre\Bionic\AbstractMessage;

/**
 * A user's tap on a template quick-reply button (incoming "button" messages)
 */
class Button extends AbstractMessage
{
    /**
     * @var string
     */
    protected $payload;

    /**
     * @var string
     */
    protected $text;

    /**
     * @return string|null
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string|null
     */
    public function getText()
    {
        return $this->text;
    }
}
