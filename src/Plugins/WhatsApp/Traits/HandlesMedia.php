<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp\Traits;


trait HandlesMedia
{
    /**
     * Retrieve media url
     *
     * @param $media_id
     * @return string
     */
    public function retrieveMediaURL($media_id)
    {
        $url = sprintf($this->url . "/%s/%s", $this->graph_api_version, $media_id);

        $this->checkForAccessToken();

        return $this->httpClient->get($url, ['headers' => ['Authorization' => 'Bearer ' . $this->access_token]]);
    }
}