<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 10:03 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Traits;


use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\AbstractEndPoint;

trait HandoverProtocol
{
    /**
     * @param AbstractEndPoint $recipient
     * @param $target_app_id
     * @param string $metadata
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function passThreadControl(AbstractEndPoint $recipient, $target_app_id, $metadata = "")
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray(),
            'target_app_id' => $target_app_id
        ];

        if ($metadata)
            $data['metadata'] = $metadata;

        $url = sprintf($this->url . "/%s/me/pass_thread_control?access_token=%s", $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->post($url, ['json' => $data]);
    }

    /**
     * @param AbstractEndPoint $recipient
     * @param string $metadata
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function takeThreadControl(AbstractEndPoint $recipient, $metadata = null)
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray()
        ];

        if (!is_null($metadata))
            $data['metadata'] = $metadata;

        $url = sprintf($this->url . "/%s/me/take_thread_control?access_token=%s", $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->post($url, ['json' => $data]);
    }

    /**
     * @param AbstractEndPoint $recipient
     * @param string $metadata
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function requestThreadControl(AbstractEndPoint $recipient, $metadata = null)
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray()
        ];

        if (!is_null($metadata))
            $data['metadata'] = $metadata;

        $url = sprintf($this->url . "/%s/me/request_thread_control?access_token=%s", $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->post($url, ['json' => $data]);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function nonPrimaryReceivers() {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $url = sprintf($this->url . "/%s/me/secondary_receivers?fields=id,name&platform=instagram&access_token=%s", $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->get($url);
    }

    /**
     * @param AbstractEndPoint $recipient
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getThreadOwner(AbstractEndPoint $recipient) {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $url = sprintf($this->url . "/%s/me/thread_owner?recipient=%s&access_token=%s", $this->graph_api_version, $recipient->getId(), $this->page_access_token);

        return $this->httpClient->get($url);
    }

    /**
     * @param AbstractEndPoint $recipient
     * @param string $seconds
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function extendThreadControl(AbstractEndPoint $recipient, $seconds = "86400")
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray(),
            'duration' => $seconds
        ];

        $url = sprintf($this->url . "/%s/me/extend_thread_control?access_token=%s", $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->post($url, ['json' => $data]);
    }

    /**
     * @param AbstractEndPoint $recipient
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function releaseThreadControl(AbstractEndPoint $recipient)
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray()
        ];

        $url = sprintf($this->url . "/%s/me/release_thread_control?access_token=%s", $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->post($url, ['json' => $data]);
    }

    /**
     * @param AbstractEndPoint $recipient
     * @param $target_app_id
     * @param string $metadata
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function passThreadMetaData(AbstractEndPoint $recipient, $target_app_id, $metadata)
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray(),
            'target_app_id' => $target_app_id,
            'metadata' => $metadata
        ];

        $url = sprintf($this->url . "/%s/me/pass_thread_metadata?access_token=%s", $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->post($url, ['json' => $data]);
    }
}