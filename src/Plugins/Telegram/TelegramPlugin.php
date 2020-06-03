<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 2:40 PM
 */

namespace Andre\Bionic\Plugins\Telegram;


use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Plugins\AbstractBionicPlugin;
use Andre\Bionic\Plugins\Telegram\Traits\Messaging;
use Andre\Bionic\Plugins\Telegram\Traits\WebhookHandler;
use GuzzleHttp\Client as HttpClient;

class TelegramPlugin extends AbstractBionicPlugin
{
    use WebhookHandler, Messaging;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var $access_token
     */
    protected $access_token;

    /**
     * @var TelegramWebHookEvent
     */
    protected $webHookEvent;

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
            'base_uri' => 'https://api.telegram.org/',
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false
        ]);
    }

    /**
     * Format access token
     *
     * @return string
     */
    protected function getToken() {
        $this->checkForAccessToken();

        return urlencode("bot" . $this->access_token);
    }

    /**
     * create a new web hook event from web hook data
     */
    protected function createWebHookEvent()
    {
        $this->webHookEvent = TelegramWebHookEvent::create($this->webHookData);
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

    /**
     * Dispatch telegram webhook events
     */
    protected function dispatchWebhookEvents() {
        $update_id = $this->webHookEvent->getUpdateId();

        try {
            if ($message = $this->webHookEvent->getMessage()) {
                $this->bionic->emit('message', [$this, $update_id, $message]);

                $this->messageEvents('message', $update_id, $message);
            }

            if ($message = $this->webHookEvent->getEditedMessage()) {
                $this->bionic->emit('edited-message', [$this, $update_id, $message]);

                $this->messageEvents('edited-message', $update_id, $message);
            }

            if ($message = $this->webHookEvent->getChannelPost()) {
                $this->bionic->emit('channel-message', [$this, $update_id, $message]);

                $this->messageEvents('channel-message', $update_id, $message);
            }

            if ($message = $this->webHookEvent->getEditedChannelPost()) {
                $this->bionic->emit('edited-channel-message', [$this, $update_id, $message]);

                $this->messageEvents('edited-channel-message', $update_id, $message);
            }

        } catch (\Exception $exception) {
            $this->bionic->emit('exception', [$exception]);
        }
    }

    /**
     * Dispatch messaging events
     *
     * @param $type
     * @param $update_id
     * @param Message $message
     */
    protected function messageEvents($type, $update_id, Message $message) {
        $user = $message->getFrom();
        $chat = $message->getChat();
        $caption = $message->getCaption();

        if ($text = $message->getText()) {
            $this->bionic->emit("$type.text", [$this, $update_id, $message, $user, $chat, $text]);
        }

        if ($photos = $message->getPhoto()) {
            $this->bionic->emit("$type.image", [$this, $update_id, $message, $user, $chat, $photos, $caption]);
        }

        if ($audio = $message->getAudio()) {
            $this->bionic->emit("$type.audio", [$this, $update_id, $message, $user, $chat, $audio, $caption]);
        }

        if ($document = $message->getDocument()) {
            $this->bionic->emit("$type.document", [$this, $update_id, $message, $user, $chat, $document, $caption]);
        }

        if ($video = $message->getVideo()) {
            $this->bionic->emit("$type.video", [$this, $update_id, $message, $user, $chat, $video, $caption]);
        }

        if ($video_note = $message->getVideoNote()) {
            $this->bionic->emit("$type.video.note", [$this, $update_id, $message, $user, $chat, $video_note]);
        }

        if ($voice = $message->getVoice()) {
            $this->bionic->emit("$type.voice", [$this, $update_id, $message, $user, $chat, $voice, $caption]);
        }

        if ($contact = $message->getContact()) {
            $this->bionic->emit("$type.contact", [$this, $update_id, $message, $user, $chat, $contact]);
        }

        if ($location = $message->getLocation()) {
            $this->bionic->emit("$type.location", [$this, $update_id, $message, $user, $chat, $location]);
        }

        if ($venue = $message->getVenue()) {
            $this->bionic->emit("$type.venue", [$this, $update_id, $message, $user, $chat, $venue]);
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