<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/3/20
 * Time: 12:25 AM
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