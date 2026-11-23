<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Telegram;

use Andre\Bionic\AbstractMessage;

class MessageEntity extends AbstractMessage
{
    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var int $offset
     */
    protected $offset;

    /**
     * @var int $length
     */
    protected $length;

    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var array $user
     */
    protected $user = [];

    /**
     * @var string $language
     */
    protected $language;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user) {
            return User::create($this->user);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
