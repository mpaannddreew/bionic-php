<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 17/06/2021
 * Time: 13:56
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Traits;


trait AccessesInstagram
{
    /**
     * @param $page_id
     * @param $fields
     * @param string $platform
     * @param string|null $user_id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function conversations($page_id, $fields, $platform = "instagram", $user_id = null) {
        $this->checkForPageAccessTokenAndGraphApiVersion();
        $url = sprintf($this->url . "/%s/$page_id/conversations?platform={$platform}&access_token=%s&fields=$fields", $this->graph_api_version, $this->page_access_token);

        if (!is_null($user_id)) {
            $url = "$url&user_id=$user_id";
        }

        return $this->httpClient->get($url);
    }

    /**
     * @param $thread_id
     * @param $fields
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function thread($thread_id, $fields) {
        $this->checkForPageAccessTokenAndGraphApiVersion();
        $url = sprintf($this->url . "/%s/$thread_id?access_token=%s&fields=$fields", $this->graph_api_version, $this->page_access_token);


        return $this->httpClient->get($url);
    }

    /**
     * @param $message_id
     * @param $fields
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function message($message_id, $fields) {
        $this->checkForPageAccessTokenAndGraphApiVersion();
        $url = sprintf($this->url . "/%s/$message_id?access_token=%s&fields=$fields", $this->graph_api_version, $this->page_access_token);


        return $this->httpClient->get($url);
    }
}