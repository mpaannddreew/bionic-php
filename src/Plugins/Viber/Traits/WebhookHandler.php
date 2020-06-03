<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 7:57 PM
 */

namespace Andre\Bionic\Plugins\Viber\Traits;


trait WebhookHandler
{
    /**
     * Set webhook
     *
     * @param $url
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setWebhook($url)
    {
        $this->checkForAccessToken();
        return $this->httpClient->post('set_webhook', [
            'headers' => $this->getTokenHeaders(),
            'json' => [
                'url' => $url,
                'send_name' => true,
                'send_photo' => true
            ]
        ]);
    }

    /**
     * Remove webhook
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function removeWebhook()
    {
        $this->checkForAccessToken();
        return $this->httpClient->post('set_webhook', [
            'headers' => $this->getTokenHeaders(),
            'json' => ['url' => ""]
        ]);
    }
}