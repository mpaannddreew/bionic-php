<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 8:32 PM
 */

namespace Andre\Bionic\Plugins\Telegram;


use Andre\Bionic\AbstractMessage;

class User extends AbstractMessage
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var boolean $is_bot
     */
    protected $is_bot;

    /**
     * @var string $first_name
     */
    protected $first_name;

    /**
     * @var string $last_name
     */
    protected $last_name;

    /**
     * @var string $username
     */
    protected $username;

    /**
     * @var string $language_code
     */
    protected $language_code;

    /**
     * @var boolean $can_join_groups
     */
    protected $can_join_groups;

    /**
     * @var boolean $can_read_all_group_messages
     */
    protected $can_read_all_group_messages;

    /**
     * @var boolean $supports_inline_queries
     */
    protected $supports_inline_queries;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isBot()
    {
        return $this->is_bot;
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
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->language_code;
    }

    /**
     * @return bool
     */
    public function isCanJoinGroups()
    {
        return $this->can_join_groups;
    }

    /**
     * @return bool
     */
    public function isCanReadAllGroupMessages()
    {
        return $this->can_read_all_group_messages;
    }

    /**
     * @return bool
     */
    public function isSupportsInlineQueries()
    {
        return $this->supports_inline_queries;
    }
}