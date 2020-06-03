<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 2:40 PM
 */

namespace Andre\Bionic\Plugins\Telegram;


use Andre\Bionic\AbstractWebHookEvent;

class TelegramWebHookEvent extends AbstractWebHookEvent
{
    /**
     * @var int $update_id
     */
    protected $update_id;

    /**
     * @var array $message
     */
    protected $message = [];

    /**
     * @var array $edited_message
     */
    protected $edited_message = [];

    /**
     * @var array $channel_post
     */
    protected $channel_post = [];

    /**
     * @var array $edited_channel_post
     */
    protected $edited_channel_post = [];

    /**
     * @var array $inline_query
     */
    protected $inline_query = [];

    /**
     * @var array $chosen_inline_result
     */
    protected $chosen_inline_result = [];

    /**
     * @var array $callback_query
     */
    protected $callback_query = [];

    /**
     * @var array $shipping_query
     */
    protected $shipping_query = [];

    /**
     * @var array $pre_checkout_query
     */
    protected $pre_checkout_query = [];

    /**
     * @var array $poll
     */
    protected $poll = [];

    /**
     * @var array $poll_answer
     */
    protected $poll_answer = [];

    /**
     * @return int
     */
    public function getUpdateId()
    {
        return $this->update_id;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        if ($this->message) {
            return Message::create($this->message);
        }

        return null;
    }

    /**
     * @return Message
     */
    public function getEditedMessage()
    {
        if ($this->edited_message) {
            return Message::create($this->edited_message);
        }

        return null;
    }

    /**
     * @return Message
     */
    public function getChannelPost()
    {
        if ($this->channel_post) {
            return Message::create($this->channel_post);
        }

        return null;
    }

    /**
     * @return Message
     */
    public function getEditedChannelPost()
    {
        if ($this->edited_channel_post) {
            return Message::create($this->edited_channel_post);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getInlineQuery()
    {
        return $this->inline_query;
    }

    /**
     * @return array
     */
    public function getChosenInlineResult()
    {
        return $this->chosen_inline_result;
    }

    /**
     * @return array
     */
    public function getCallbackQuery()
    {
        return $this->callback_query;
    }

    /**
     * @return array
     */
    public function getShippingQuery()
    {
        return $this->shipping_query;
    }

    /**
     * @return array
     */
    public function getPreCheckoutQuery()
    {
        return $this->pre_checkout_query;
    }

    /**
     * @return array
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * @return array
     */
    public function getPollAnswer()
    {
        return $this->poll_answer;
    }
}