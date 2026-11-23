<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;

use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Coordinates;

class Payload extends AbstractMessage
{
    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var int
     */
    protected $sticker_id;

    /**
     * @var string
     */
    protected $message_id;

    /**
     * @var string
     */
    protected $reaction;

    /**
     * get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * get sticker_id
     *
     * @return int
     */
    public function getStickerId()
    {
        return $this->sticker_id;
    }

    /**
     * @return mixed
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @return mixed
     */
    public function getReaction()
    {
        return $this->reaction;
    }
}
