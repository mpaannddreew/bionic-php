<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 12:02 PM
 */

namespace Andre\Bionic;



use Andre\Bionic\Contracts\BionicInterface;
use Andre\Bionic\Plugins\AbstractBionicPlugin;
use Evenement\EventEmitter;

abstract class AbstractBionicClient extends EventEmitter implements BionicInterface
{
    /**
     * @var AbstractBionicPlugin
     */
    protected $plugin;

    /**
     * @var bool
     */
    protected $executed = False;

    /**
     * @var AbstractWebHookEvent
     */
    protected $webHookEvent;

    /**
     * @var AbstractMessage
     */
    protected $message;

    /**
     * Client constructor.
     * @param AbstractBionicPlugin $plugin
     */
    public function __construct(AbstractBionicPlugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Receive incoming web hook event
     *
     * @param AbstractWebHookEvent $event
     * @return $this
     */
    public function receive(AbstractWebHookEvent $event)
    {
        $this->webHookEvent = $event;
        return $this;
    }

    protected function hasExecuted()
    {
        $this->executed = True;
    }

    /**
     * @return AbstractBionicPlugin
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
     * @return AbstractWebHookEvent
     */
    public function getWebHookEvent()
    {
        return $this->webHookEvent;
    }

    /**
     * @return AbstractMessage
     */
    public function getMessage()
    {
        return $this->message;
    }
}