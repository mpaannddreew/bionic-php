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

abstract class AbstractBionic extends EventEmitter implements BionicInterface
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
     * @var array
     */
    protected $webHookData;

    /**
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
     * execute client
     */
    public function execute(){
        if ($this->isExecuted())
            return;

        $this->hasExecuted();
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
     * @return array
     */
    public function getWebHookData()
    {
        return $this->webHookData;
    }
}