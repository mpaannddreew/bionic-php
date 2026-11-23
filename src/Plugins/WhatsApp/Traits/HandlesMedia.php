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
     * Retrieve a media object (url, mime_type, sha256, file_size, id).
     *
     * Returns the raw HTTP response; see retrieveMedia() for the decoded array.
     *
     * @param string $media_id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function retrieveMediaURL($media_id)
    {
        $url = sprintf($this->url . "/%s/%s", $this->graph_api_version, $media_id);

        $this->checkForAccessToken();

        return $this->httpClient->get($url, ['headers' => ['Authorization' => 'Bearer ' . $this->access_token]]);
    }

    /**
     * Retrieve a media object by id.
     *
     * Returns the decoded response: messaging_product, url, mime_type, sha256,
     * file_size and id. The url is valid for 5 minutes; pass it to downloadMedia().
     *
     * @param string $media_id
     * @param string|null $phone_number_id only return the media if it belongs to this business phone number
     * @return array
     */
    public function retrieveMedia($media_id, $phone_number_id = null)
    {
        $this->checkForAccessToken();

        $url = sprintf($this->url . "/%s/%s", $this->graph_api_version, rawurlencode((string) $media_id));

        $options = ['headers' => ['Authorization' => 'Bearer ' . $this->access_token]];

        if ($phone_number_id !== null) {
            $options['query'] = ['phone_number_id' => $phone_number_id];
        }

        return json_decode($this->httpClient->get($url, $options)->getBody()->getContents(), true);
    }

    /**
     * Download media from a media URL (from retrieveMedia() or a webhook's url field).
     *
     * Returns the file's raw bytes. Pass $sink (a file path or resource) to stream
     * the file there instead; the method then returns an empty string.
     *
     * @param string $media_url
     * @param string|resource|null $sink
     * @return string
     */
    public function downloadMedia($media_url, $sink = null)
    {
        $this->checkForAccessToken();

        $options = ['headers' => ['Authorization' => 'Bearer ' . $this->access_token]];

        if ($sink !== null) {
            $options['sink'] = $sink;
        }

        $response = $this->httpClient->get($media_url, $options);

        return $sink === null ? (string) $response->getBody() : '';
    }
}
