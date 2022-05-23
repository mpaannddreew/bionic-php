<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 23/05/2022
 * Time: 13:04
 */

namespace Andre\Bionic\Plugins\WhatsApp\Traits;


use Andre\Bionic\AbstractMessage;

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
     * send message
     *
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function send(array $data)
    {
        $this->checkForPhoneNumberId();

        $this->checkForAccessToken();

        return $this->httpClient->post($this->messagingFullUrl(), [
            'json' => array_merge($data, [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
            ])
        ]);
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