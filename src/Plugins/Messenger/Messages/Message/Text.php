<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 10:43 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;

class Text extends AbstractMessage
{
    /**
     * @var string $text
     */
    protected $text;

    /**
     * get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * set text
     *
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->data['text'] = $this->getText();
        return $this;
    }
}