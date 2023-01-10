<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 23/05/2022
 * Time: 13:04
 */

namespace Andre\Bionic\Plugins\WhatsApp\Traits;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppValue;

trait SendsMessages
{
    /**
     * Send text
     *
     * @param AbstractMessage $message
     * @param $recipient
     * @param $type
     * @return WhatsAppValue
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
            'headers' => [
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' =>  'application/json'
            ],
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
     * @param array $data
     * @return WhatsAppValue
     */
    public function send(array $data)
    {
        $this->checkForPhoneNumberId();

        $this->checkForAccessToken();

        $response = $this->httpClient->post($this->messagingFullUrl(), [
            'headers' => ['Authorization' => 'Bearer ' . $this->access_token],
            'json' => array_merge($data, [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
            ])
        ]);

        return WhatsAppValue::create(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * messaging full url
     *
     * @return string
     */
    protected function messagingFullUrl()
    {
        return sprintf($this->url . "/%s/%s/messages", $this->graph_api_version, $this->phone_number_id);
    }
}