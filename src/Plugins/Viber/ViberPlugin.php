<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 7:50 PM
 */

namespace Andre\Bionic\Plugins\Viber;


use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Plugins\AbstractBionicPlugin;
use Andre\Bionic\Plugins\Viber\Traits\AccountHandler;
use Andre\Bionic\Plugins\Viber\Traits\Messaging;
use Andre\Bionic\Plugins\Viber\Traits\WebhookHandler;
use GuzzleHttp\Client as HttpClient;

class ViberPlugin extends AbstractBionicPlugin
{
    use WebhookHandler, Messaging, AccountHandler;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var $access_token
     */
    protected $access_token;

    /**
     * ViberPlugin constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->httpClient = $this->newHttpClient();
    }

    /**
     * set new access token
     *
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * create new http client
     *
     * @return HttpClient
     */
    protected function newHttpClient()
    {
        return new HttpClient([
            'base_uri' => 'https://chatapi.viber.com/pa/',
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false
        ]);
    }

    protected function getTokenHeaders()
    {
        return ['X-Viber-Auth-Token' => $this->access_token];
    }

    /**
     * create a new web hook event from web hook data
     */
    protected function createWebHookEvent()
    {
        $this->webHookEvent = ViberWebHookEvent::create($this->webHookData);
    }

    /**
     * emit events
     *
     * @param AbstractBionic $bionic
     */
    public function emitEvents(AbstractBionic $bionic)
    {
        $this->bionic = $bionic;
        $this->runPluginTasks();
        $this->dispatchWebhookEvents();
    }

    protected function dispatchWebhookEvents()
    {
        $event = $this->webHookEvent->getEvent();
        $timestamp = $this->webHookEvent->getTimestamp();
        $message_token = $this->webHookEvent->getMessageToken();

        if ($event == 'webhook')
            $this->bionic->emit('webhook', [$this, $timestamp, $message_token]);

        if ($event == 'subscribed')
            $this->bionic->emit('subscribed', [$this, $timestamp, $message_token, $this->webHookEvent->getUser()]);

        if ($event == 'unsubscribed')
            $this->bionic->emit('un-subscribed', [$this, $timestamp, $message_token,
                $this->webHookEvent->getUserId()]);

        if ($event == 'conversation_started')
            $this->bionic->emit('conversation-started', [$this, $timestamp, $message_token,
                $this->webHookEvent->getType(), $this->webHookEvent->getContext(), $this->webHookEvent->getUser(),
                $this->webHookEvent->isSubscribed()]);

        if ($event == 'delivered')
            $this->bionic->emit('delivered', [$this, $timestamp, $message_token, $this->webHookEvent->getUserId()]);

        if ($event == 'seen')
            $this->bionic->emit('seen', [$this, $timestamp, $message_token, $this->webHookEvent->getUserId()]);

        if ($event == 'failed')
            $this->bionic->emit('failed', [$this, $timestamp, $message_token, $this->webHookEvent->getUserId(),
                $this->webHookEvent->getDesc()]);

        if ($event == 'message') {
            $message = $this->webHookEvent->getMessage();
            $this->bionic->emit('message', [$this, $timestamp, $message_token, $this->webHookEvent->getSender(),
                $message]);

            if ($message->getText()) {
                $this->bionic->emit('message.text', [$this, $timestamp, $message_token,
                    $this->webHookEvent->getSender(), $message, $message->getText()]);
            }

            if ($message->getImage()) {
                $this->bionic->emit('message.image', [$this, $timestamp, $message_token,
                    $this->webHookEvent->getSender(), $message, $message->getImage()]);
            }

            if ($message->getUrl()) {
                $this->bionic->emit('message.url', [$this, $timestamp, $message_token,
                    $this->webHookEvent->getSender(), $message, $message->getUrl()]);
            }

            if ($message->getLocation()) {
                $this->bionic->emit('message.location', [$this, $timestamp, $message_token,
                    $this->webHookEvent->getSender(), $message, $message->getLocation()]);
            }

            if ($message->getContact()) {
                $this->bionic->emit('message.contact', [$this, $timestamp, $message_token,
                    $this->webHookEvent->getSender(), $message, $message->getContact()]);
            }

            if ($message->getVideo()) {
                $this->bionic->emit('message.video', [$this, $timestamp, $message_token,
                    $this->webHookEvent->getSender(), $message, $message->getVideo()]);
            }

            if ($message->getFile()) {
                $this->bionic->emit('message.file', [$this, $timestamp, $message_token,
                    $this->webHookEvent->getSender(), $message, $message->getFile()]);
            }
        }
    }

    /**
     * check if access token has been provided before making any http request
     */
    protected function checkForAccessToken()
    {
        if (!$this->access_token)
            throw new \InvalidArgumentException('An access token has not been specified!');
    }
}