<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:16 PM
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
     * @return User
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