<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:48 PM
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