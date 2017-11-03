<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 11:24 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;



use Andre\Bionic\AbstractMessage;

class EntryMessage extends AbstractMessage
{
    /**
     * @var $id
     */
    protected $id;

    /**
     * @var $time
     */
    protected $time;

    /**
     * @var array $messaging
     */
    protected $messaging = [];

    /**
     * @var array $messaging_items
     */
    protected $messaging_items = [];

    /**
     * EntryMessage constructor.
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->populateMessagingItems();
    }

    /**
     * populate messaging items
     */
    protected function populateMessagingItems()
    {
        foreach ($this->messaging as $messaging_item)
        {
            array_push($this->messaging_items, new MessagingItem($messaging_item));
        }
    }

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
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return array
     */
    public function getMessaging()
    {
        return $this->messaging;
    }

    /**
     * @return array
     */
    public function getMessagingItems()
    {
        return $this->messaging_items;
    }
}