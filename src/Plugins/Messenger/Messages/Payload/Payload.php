<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 2:24 PM
 *
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
     * @var $sticker_id
     */
    protected $sticker_id;

    /**
     * @var $message_id
     */
    protected $message_id;

    /**
     * @var $reaction
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
     * @return string
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