<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 10:43 PM
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
}