<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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