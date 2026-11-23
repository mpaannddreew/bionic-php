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

class Dice extends AbstractMessage
{
    /**
     * @var string $emoji
     */
    protected $emoji;

    /**
     * @var int $value
     */
    protected $value;

    /**
     * @return string
     */
    public function getEmoji()
    {
        return $this->emoji;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
}