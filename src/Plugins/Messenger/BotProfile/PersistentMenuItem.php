<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 5:33 PM
 */

namespace Andre\Bionic\Plugins\Messenger\BotProfile;


use Andre\Bionic\AbstractMessage;

class PersistentMenuItem extends AbstractMessage
{
    /**
     * @var array $call_to_actions
     */
    protected $call_to_actions = [];

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * get call to actions
     *
     * @return array
     */
    public function getCallToActions()
    {
        return $this->call_to_actions;
    }

    /**
     * set call to actions
     *
     * @param array $call_to_actions
     * @return $this
     */
    public function setCallToActions($call_to_actions)
    {
        $this->call_to_actions = $call_to_actions;
        $this->data['call_to_actions'] = $this->getCallToActions();
        return $this;
    }

    /**
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->data['title'] = $this->getTitle();
        return $this;
    }

    /**
     * get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * set title
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->data['type'] = $this->getType();
        return $this;
    }
}