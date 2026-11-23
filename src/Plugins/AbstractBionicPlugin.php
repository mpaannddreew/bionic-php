<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins;

use Andre\Bionic\AbstractWebHookEvent;
use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Contracts\PluginInterface;
use GuzzleHttp\Client as HttpClient;

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
     * @var HttpClient
     */
    protected $httpClient;

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
     * Replace the HTTP client the plugin sends requests with, e.g. to add
     * timeouts, a proxy, retry middleware or a mock handler in tests.
     *
     * Set the headers your platform needs (WhatsApp, Messenger, Telegram and
     * Viber all expect 'Content-Type: application/json') and, for Telegram and
     * Viber, the base_uri the plugin's own client uses.
     *
     * @param HttpClient $httpClient
     * @return $this
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * setup plugin configurations
     */
    protected function setUpConfigurations()
    {
        foreach ($this->config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
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
        return new static($config); // @phpstan-ignore new.static (subclasses add their own constructors)
    }
}
