<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp;

use Andre\Bionic\AbstractMessage;

class Status extends AbstractMessage
{
    protected $id;

    protected $recipient_id;

    protected $status;

    protected $timestamp;

    /**
     * @var string
     */
    protected $recipient_user_id;

    /**
     * @var string
     */
    protected $biz_opaque_callback_data;

    /**
     * @var array
     */
    protected $conversation = [];

    /**
     * @var array
     */
    protected $pricing = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRecipientId()
    {
        return $this->recipient_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * The recipient's business-scoped user ID (BSUID)
     *
     * @return string|null
     */
    public function getRecipientUserId()
    {
        return $this->recipient_user_id;
    }

    /**
     * @return string|null
     */
    public function getBizOpaqueCallbackData()
    {
        return $this->biz_opaque_callback_data;
    }

    /**
     * Conversation details (id, expiration_timestamp, origin.type), when Meta includes them
     *
     * @return array
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * Pricing details (billable, pricing_model, type, category), when Meta includes them
     *
     * @return array
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * Why a message failed (only on "failed" statuses)
     *
     * @return Error[]
     */
    public function getErrors()
    {
        return array_map(fn ($error) => Error::create($error), $this->errors);
    }
}
