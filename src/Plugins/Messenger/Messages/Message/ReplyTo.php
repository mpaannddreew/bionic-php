<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;

use Andre\Bionic\AbstractMessage;

class ReplyTo extends AbstractMessage
{
    /**
     * @var string
     */
    protected $mid;

    /**
     * @var array $story
     */
    protected $story = [];

    /**
     * @return mixed
     */
    public function getMid()
    {
        return $this->mid;
    }

    /**
     * get story
     *
     * @return array
     */
    public function getStory()
    {
        return $this->story;
    }
}
