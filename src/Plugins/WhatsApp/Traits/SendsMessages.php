<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 23/05/2022
 * Time: 13:04
 */

namespace Andre\Bionic\Plugins\WhatsApp\Traits;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\WhatsApp\Message;

trait SendsMessages
{
    /**
     * Send text
     *
     * @param AbstractMessage $message
     * @param $recipient
     * @param $type
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendMessage($type, AbstractMessage $message, $recipient) {
        return $this->send(['type' => $type, 'to' => $recipient, $type => $message->toArray()]);
    }

    /**
     * Mark message as read
     *
     * @param $message_id
     * @return mixed
     */
    public function markRead($message_id) {
        $this->checkForPhoneNumberId();

        $this->checkForAccessToken();

        return $this->httpClient->post($this->messagingFullUrl(), [
            'json' => [
                "messaging_product" => "whatsapp",
                "status" => "read",
                "message_id" => $message_id
            ]
        ]);
    }

    /**
     * send message
     *
     * @param $data
     * @return Message
     */
    protected function send(array $data)
    {
        $this->checkForPhoneNumberId();

        $this->checkForAccessToken();

        $response = $this->httpClient->post($this->messagingFullUrl(), [
            'json' => array_merge($data, [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
            ])
        ]);

        return Message::create(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * messaging full url
     *
     * @return string
     */
    protected function messagingFullUrl()
    {
        return sprintf($this->url . "/%s/%s/messages?access_token=%s", $this->graph_api_version, $this->phone_number_id, $this->access_token);
    }
}