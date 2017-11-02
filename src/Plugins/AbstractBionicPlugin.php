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
use Andre\Bionic\AbstractBionicClient;
use Andre\Bionic\Contracts\PluginInterface;
use GuzzleHttp\Client as HttpClient;

abstract class AbstractBionicPlugin implements PluginInterface
{
    /**
     * @var AbstractBionicClient
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
    protected abstract function getClientOptions();

    /**
     * create new http client
     *
     * @return HttpClient
     */
    protected function newHttpClient()
    {
        $options = $this->getClientOptions();
        return new HttpClient($options);
    }

    /**
     * set web hook event
     */
    protected function setWebHookEvent()
    {
        $this->webHookEvent = $this->client->getWebHookEvent();
    }

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
    protected function runClientTasks()
    {
        $this->setWebHookEvent();
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