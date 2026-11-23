<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Viber\Messages;



class Text extends ViberMessage
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

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::TEXT;
    }
}