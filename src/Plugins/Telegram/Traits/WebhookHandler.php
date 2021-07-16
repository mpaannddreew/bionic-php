<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 6:04 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Traits;


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
        return $this->httpClient->post($this->getToken() . '/setWebhook', [
            'json' => [
                'url' => $url,
                'allowed_updates' => []
            ]
        ]);
    }

    /**
     * Delete webhook
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteWebhook()
    {
        return $this->httpClient->post($this->getToken() . '/deleteWebhook');
    }

    /**
     * Get webhook information
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getWebhookInfo() {
        return $this->httpClient->post($this->getToken() . '/getWebhookInfo');
    }
}