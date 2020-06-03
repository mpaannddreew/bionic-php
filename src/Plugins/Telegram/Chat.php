<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 8:38 PM
 */

namespace Andre\Bionic\Plugins\Telegram;


use Andre\Bionic\AbstractMessage;

class Chat extends AbstractMessage
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $username
     */
    protected $username;

    /**
     * @var string $first_name
     */
    protected $first_name;

    /**
     * @var string $last_name
     */
    protected $last_name;

    /**
     * @var array $photo
     */
    protected $photo = [];

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $invite_link
     */
    protected $invite_link;

    /**
     * @var array $pinned_message
     */
    protected $pinned_message = [];

    /**
     * @var array $permissions
     */
    protected $permissions = [];

    /**
     * @var boolean $slow_mode_delay
     */
    protected $slow_mode_delay;

    /**
     * @var string $sticker_set_name
     */
    protected $sticker_set_name;

    /**
     * @var boolean $can_set_sticker_set
     */
    protected $can_set_sticker_set;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return array
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getInviteLink()
    {
        return $this->invite_link;
    }

    /**
     * @return Message
     */
    public function getPinnedMessage()
    {
        if ($this->pinned_message) {
            return Message::create($this->pinned_message);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return bool
     */
    public function isSlowModeDelay()
    {
        return $this->slow_mode_delay;
    }

    /**
     * @return string
     */
    public function getStickerSetName()
    {
        return $this->sticker_set_name;
    }

    /**
     * @return bool
     */
    public function isCanSetStickerSet()
    {
        return $this->can_set_sticker_set;
    }
}