<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/3/20
 * Time: 7:25 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Traits;


use Andre\Bionic\Plugins\Telegram\Message;
use Andre\Bionic\Plugins\Telegram\Messages\Contact;
use Andre\Bionic\Plugins\Telegram\Messages\Location;
use Andre\Bionic\Plugins\Telegram\Messages\Text;
use Andre\Bionic\Plugins\Telegram\Messages\Venue;
use Andre\Bionic\Plugins\Telegram\User;

trait Messaging
{

    /**
     * Get bot information
     *
     * @return User
     */
    public function getMe() {
        $response = $this->httpClient->post($this->getToken() . "/getMe");

        return User::create(json_decode($response->getBody()->getContents())->result);
    }

    /**
     * Create message object
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return Message
     */
    protected function message(\Psr\Http\Message\ResponseInterface $response) {
        return Message::create(json_decode($response->getBody()->getContents())->result);
    }

    /**
     * Send text
     *
     * @param $chat
     * @param Text $text
     * @return Message
     */
    public function sendText($chat, Text $text) {
        return $this->message($this->httpClient->post($this->getToken() . '/sendMessage', [
            'json' => array_merge(['chat_id' => $chat], $text->toArray())
        ]));
    }

    /**
     * Send picture
     *
     * @param $chat
     * @param $photo
     * @param string $caption
     * @return Message
     */
    public function sendPhoto($chat, $photo, $caption = '') {
        return $this->message($this->httpClient->post($this->getToken() . '/sendPhoto', [
            'json' => [
                'chat_id' => $chat,
                'photo' => $photo,
                'caption' => $caption
            ]
        ]));
    }

    /**
     * Send audio
     *
     * @param $chat
     * @param $audio
     * @param string $caption
     * @return Message
     */
    public function sendAudio($chat, $audio, $caption = '') {
        return $this->message($this->httpClient->post($this->getToken() . '/sendAudio', [
            'json' => [
                'chat_id' => $chat,
                'audio' => $audio,
                'caption' => $caption
            ]
        ]));
    }

    /**
     * Send document
     *
     * @param $chat
     * @param $document
     * @param string $caption
     * @return Message
     */
    public function sendDocument($chat, $document, $caption = '') {
        return $this->message($this->httpClient->post($this->getToken() . '/sendDocument', [
            'json' => [
                'chat_id' => $chat,
                'document' => $document,
                'caption' => $caption
            ]
        ]));
    }

    /**
     * Send video
     *
     * @param $chat
     * @param $video
     * @param string $caption
     * @return Message
     */
    public function sendVideo($chat, $video, $caption = '') {
        return $this->message($this->httpClient->post($this->getToken() . '/sendVideo', [
            'json' => [
                'chat_id' => $chat,
                'video' => $video,
                'caption' => $caption
            ]
        ]));
    }

    /**
     * Send animation
     *
     * @param $chat
     * @param $animation
     * @param string $caption
     * @return Message
     */
    public function sendAnimation($chat, $animation, $caption = '') {
        return $this->message($this->httpClient->post($this->getToken() . '/sendAnimation', [
            'json' => [
                'chat_id' => $chat,
                'animation' => $animation,
                'caption' => $caption
            ]
        ]));
    }

    /**
     * Send voice
     *
     * @param $chat
     * @param $voice
     * @param string $caption
     * @return Message
     */
    public function sendVoice($chat, $voice, $caption = '') {
        return $this->message($this->httpClient->post($this->getToken() . '/sendVoice', [
            'json' => [
                'chat_id' => $chat,
                'voice' => $voice,
                'caption' => $caption
            ]
        ]));
    }

    /**
     * Send contact
     *
     * @param $chat
     * @param Contact $contact
     * @return Message
     */
    public function sendContact($chat, Contact $contact) {
        return $this->message($this->httpClient->post($this->getToken() . '/sendContact', [
            'json' => array_merge(['chat_id' => $chat], $contact->toArray())
        ]));
    }

    /**
     * Send location
     *
     * @param $chat
     * @param Location $location
     * @return Message
     */
    public function sendLocation($chat, Location $location) {
        return $this->message($this->httpClient->post($this->getToken() . '/sendLocation', [
            'json' => array_merge(['chat_id' => $chat], $location->toArray())
        ]));
    }

    /**
     * Send venue
     *
     * @param $chat
     * @param Venue $venue
     * @return Message
     */
    public function sendVenue($chat, Venue $venue) {
        return $this->message($this->httpClient->post($this->getToken() . '/sendVenue', [
            'json' => array_merge([
                'chat_id' => $chat,
                'title' => $venue->getTitle(),
                'address' => $venue->getAddress()
            ], $venue->getLocation()->toArray())
        ]));
    }
}