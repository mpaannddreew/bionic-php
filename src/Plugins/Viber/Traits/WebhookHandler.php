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
