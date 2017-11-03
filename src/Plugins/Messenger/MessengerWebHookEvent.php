<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 3:23 PM
 */

namespace Andre\Bionic\Plugins\Messenger;


use Andre\Bionic\AbstractWebHookEvent;
use Andre\Bionic\Plugins\Messenger\Messages\EntryMessage;

class MessengerWebHookEvent extends AbstractWebHookEvent
{
    /**
     * @var string $object
     */
    protected $object;

    /**
     * @var array $entry
     */
    protected $entry = [];

    /**
     * @var array $entry_messages
     */
    protected $entry_messages = [];

    /**
     * MessengerWebHookEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setAttributes();
        $this->populateEntryMessages();
    }

    protected function setAttributes()
    {
        foreach ($this->data as $key => $value){
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    protected function populateEntryMessages()
    {
        foreach ($this->entry as $entry_message)
        {
            array_push($this->entry_messages, new EntryMessage($entry_message));
        }
    }

    /**
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return array
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @return array
     */
    public function getEntryMessages()
    {
        return $this->entry_messages;
    }
}