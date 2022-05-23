<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 23/05/2022
 * Time: 19:25
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
    protected function retrieveMediaURL($media_id)
    {
        $url = sprintf($this->url . "/%s/%s?access_token=%s", $this->graph_api_version, $media_id, $this->access_token);

        $this->checkForAccessToken();

        return $this->httpClient->get($url);
    }
}