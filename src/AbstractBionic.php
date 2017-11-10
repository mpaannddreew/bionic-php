<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 12:02 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic;



use Andre\Bionic\Contracts\BionicInterface;
use Andre\Bionic\Plugins\AbstractBionicPlugin;
use Evenement\EventEmitter;

abstract class AbstractBionic extends EventEmitter implements BionicInterface
{
    /**
     * a plugin instance
     *
     * @var AbstractBionicPlugin
     */
    protected $plugin;

    /**
     * @var bool
     */
    protected $executed = False;

    /**
     * @var array
     */
    protected $webHookData;

    /**
     * @var array
     */
    protected $listen = [];

    /**
     * create a new bionic instance
     *
     * AbstractBionicClient constructor.
     */
    public function __construct(){}

    /**
     * set plugin to use
     *
     * @param AbstractBionicPlugin $plugin
     * @return $this
     */
    public function setPlugin(AbstractBionicPlugin $plugin)
    {
        $this->plugin = $plugin;
        return $this;
    }

    /**
     * Receive incoming web hook event
     *
     * @param array $webHookData
     */
    public function receive($webHookData)
    {
        $this->webHookData = $webHookData;
        $this->execute();
    }

    /**
     * register an event listener
     *
     * @param $event
     * @param $listener
     */
    public function listen($event, $listener)
    {
        $this->listen[$event][] = $listener;
    }


    /**
     * register event listeners
     */
    protected function registerEventListeners()
    {
        foreach ($this->listen as $event => $listeners){
            foreach ($listeners as $listener){
                $this->on($event, $listener);
            }
        }
    }

    /**
     * execute client
     */
    public function execute(){
        if ($this->isExecuted())
            return;

        $this->hasExecuted();
        $this->registerEventListeners();
        $this->plugin->emitEvents($this);
    }

    /**
     * has client executed
     */
    protected function hasExecuted()
    {
        $this->executed = True;
    }

    /**
     * get current plugin
     *
     * @return AbstractBionicPlugin
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     * get registered listeners for events
     *
     * @return array
     */
    public function getListen()
    {
        return $this->listen;
    }

    /**
     * @return bool
     */
    public function isExecuted()
    {
        return $this->executed;
    }

    /**
     * @return array
     */
    public function getWebHookData()
    {
        return $this->webHookData;
    }

    /**
     * create a new class instance
     *
     * @return static
     */
    public static function initialize()
    {
        return new static();
    }
}