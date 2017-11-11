<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 11:24 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;



use Andre\Bionic\AbstractMessage;

class EntryItem extends AbstractMessage
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var int $time
     */
    protected $time;

    /**
     * @var array $messaging
     */
    protected $messaging = [];

    /**
     * @var array $standby
     */
    protected $standby = [];

    /**
     * @var array $messaging_items
     */
    protected $messaging_items = [];

    /**
     * @var array $standby_items
     */
    protected $standby_items = [];

    /**
     * EntryMessage constructor.
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->populateMessagingItems();
        $this->populateStandbyItems();
    }

    /**
     * populate messaging items
     */
    protected function populateMessagingItems()
    {
        foreach ($this->messaging as $messaging_item)
        {
            array_push($this->messaging_items, MessagingItem::create($messaging_item));
        }
    }

    /**
     * populate standby items
     */
    protected function populateStandbyItems()
    {
        foreach ($this->standby as $standby_item)
        {
            array_push($this->standby_items, StandbyItem::create($standby_item));
        }
    }

    /**
     * get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * get messaging object
     *
     * @return array
     */
    public function getMessaging()
    {
        return $this->messaging;
    }

    /**
     * get messaging items
     *
     * @return array
     */
    public function getMessagingItems()
    {
        return $this->messaging_items;
    }

    /**
     * get standby object
     *
     * @return array
     */
    public function getStandby()
    {
        return $this->standby;
    }

    /**
     * get standby items
     *
     * @return array
     */
    public function getStandbyItems()
    {
        return $this->standby_items;
    }
}