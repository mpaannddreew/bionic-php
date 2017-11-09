<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:35 AM
 */

namespace Andre\Bionic\Plugins;


use Andre\Bionic\AbstractWebHookEvent;
use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Contracts\PluginInterface;

abstract class AbstractBionicPlugin implements PluginInterface
{
    /**
     * @var AbstractBionic
     */
    protected $bionic;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var AbstractWebHookEvent
     */
    protected $webHookEvent;

    /**
     * @var array
     */
    protected $webHookData;

    /**
     * AbstractBionicPlugin constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->setUpConfigurations();
    }

    /**
     * setup plugin configurations
     */
    protected function setUpConfigurations()
    {
        foreach ($this->config as $key => $value) {
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    /**
     * set web hook event
     */
    protected function setWebHookData()
    {
        $this->webHookData = $this->bionic->getWebHookData();
    }

    /**
     * create a new web hook event from web hook data
     */
    abstract protected function createWebHookEvent();

    /**
     * run client tasks
     */
    protected function runPluginTasks()
    {
        $this->setWebHookData();
        $this->createWebHookEvent();
    }

    /**
     * create a new class instance
     *
     * @param array $config
     * @return static
     */
    public static function create($config = [])
    {
        return new static($config);
    }
}