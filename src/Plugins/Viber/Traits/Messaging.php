<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Viber\Traits;


use Andre\Bionic\Plugins\Viber\Messages\ViberMessage;
use Andre\Bionic\Plugins\Viber\Sender;

trait Messaging
{
    /**
     * Send message
     *
     * @param $subscriber
     * @param Sender $sender
     * @param ViberMessage $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendMessage($subscriber, Sender $sender, ViberMessage $message) {
        $this->checkForAccessToken();

        return $this->httpClient->post('send_message', [
            'headers' => $this->getTokenHeaders(),
            'json' => array_merge([
                'receiver' => $subscriber,
                'min_api_version' => 1,
                'sender' => $sender->toArray(),
            ], $message->toArray())
        ]);
    }

    /**
     * Send broadcast message
     *
     * @param array $subscribers
     * @param Sender $sender
     * @param ViberMessage $message
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendBroadcast(array $subscribers, Sender $sender, ViberMessage $message) {
        $this->checkForAccessToken();

        return $this->httpClient->post('broadcast_message', [
            'headers' => $this->getTokenHeaders(),
            'json' => array_merge([
                'min_api_version' => 1,
                'sender' => $sender->toArray(),
                'broadcast_list' => $subscribers
            ], $message->toArray())
        ]);
    }
}