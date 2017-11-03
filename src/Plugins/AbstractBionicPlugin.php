<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:35 AM
 */

namespace Andre\Bionic\Plugins;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\AbstractWebHookEvent;
use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Contracts\PluginInterface;
use GuzzleHttp\Client as HttpClient;

abstract class AbstractBionicPlugin implements PluginInterface
{
    /**
     * @var AbstractBionic
     */
    protected $client;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $url;

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
     * @var array
     */
    protected $listen = [];

    /**
     * AbstractBionicPlugin constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->setUpConfigurations();
        $this->httpClient = $this->newHttpClient();
    }

    /**
     * setup plugin configurations
     */
    protected function setUpConfigurations()
    {
        foreach ($this->config as $key => $value){
            if (property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

    /**
     * @return array
     */
    protected abstract function defineHttpClientOptions();

    /**
     * create new http client
     *
     * @return HttpClient
     */
    protected function newHttpClient()
    {
        $options = $this->defineHttpClientOptions();
        return new HttpClient($options);
    }

    /**
     * set web hook event
     */
    protected function setWebHookData()
    {
        $this->webHookData = $this->client->getWebHookData();
    }

    /**
     * create a new web hook event from web hook data
     */
    abstract protected function createWebHookEvent();

    /**
     * register event listeners
     */
    protected function registerEvents()
    {
        foreach ($this->listen as $key => $value){
            foreach ($value as $listener){
                $this->client->on($key, $listener);
            }
        }
    }

    /**
     * run client tasks
     */
    protected function runPluginTasks()
    {
        $this->setWebHookData();
        $this->createWebHookEvent();
        $this->registerEvents();
    }

    /**
     * send message
     *
     * @param AbstractMessage $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(AbstractMessage $message)
    {
        return $this->httpClient->post($this->url, ['json' => $message->toArray()]);
    }
}