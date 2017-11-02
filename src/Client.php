<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 9:45 PM
 */

namespace Andre\Bionic\Client;


use Andre\Bionic\Contracts\BionicInterface;
use Andre\Bionic\Contracts\MessageInterface;
use Andre\Bionic\Contracts\PluginInterface;
use Andre\Bionic\Contracts\WebHookEventInterface;
use Evenement\EventEmitter;

class Client extends EventEmitter implements BionicInterface
{
    /**
     * @var PluginInterface
     */
    protected $plugin;

    /**
     * @var bool
     */
    protected $executed = False;

    /**
     * @var WebHookEventInterface
     */
    protected $event;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * Client constructor.
     * @param PluginInterface $plugin
     */
    public function __construct(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Receive incoming webhook event
     *
     * @param WebHookEventInterface $event
     * @return $this
     */
    public function receive(WebHookEventInterface $event)
    {
        $this->event = $event;
        return $this;
    }

    public function execute(){
        if ($this->isExecuted())
            return;

        $this->hasExecuted();
        $this->plugin->attachEvents($this);
        // todo client execution
    }

    /**
     * send message
     *
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message)
    {
        $this->message = $message;
        // todo sending message to messaging platform
    }

    protected function hasExecuted()
    {
        $this->executed = True;
    }

    /**
     * @return PluginInterface
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * @return bool
     */
    public function isExecuted()
    {
        return $this->executed;
    }

    /**
     * @return WebHookEventInterface
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }
}