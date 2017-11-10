<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 3:23 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger;


use Andre\Bionic\AbstractWebHookEvent;
use Andre\Bionic\Plugins\Messenger\Messages\EntryItem;

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
     * @var array $entry_items
     */
    protected $entry_items = [];

    /**
     * MessengerWebHookEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->populateEntryMessages();
    }

    /**
     * populate entry items
     */
    protected function populateEntryMessages()
    {
        foreach ($this->entry as $entry_item)
        {
            array_push($this->entry_items, EntryItem::create($entry_item));
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
    public function getEntryItems()
    {
        return $this->entry_items;
    }
}