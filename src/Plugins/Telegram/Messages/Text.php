<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;

use Andre\Bionic\AbstractMessage;

class Text extends AbstractMessage
{
    /**
     * @var string $text
     */
    protected $text;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
