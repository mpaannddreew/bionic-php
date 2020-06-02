<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 12:25 PM
 */

namespace Andre\Bionic\Plugins\Viber\Traits;


trait AccountHandler
{
    /**
     * Get account information
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getAccountInfo() {
        $this->checkForAccessToken();

        return $this->httpClient->post('get_account_info', [
            'headers' => $this->getTokenHeaders()
        ]);
    }

    /**
     * Get account information
     *
     * @param $subscriber
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUserDetails($subscriber) {
        $this->checkForAccessToken();

        return $this->httpClient->post('get_user_details', [
            'headers' => $this->getTokenHeaders(),
            'json' => [
                'id' => $subscriber
            ]
        ]);
    }

    /**
     * Get online status
     *
     * @param $subscribers
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOnline($subscribers) {
        $this->checkForAccessToken();

        return $this->httpClient->post('get_online', [
            'headers' => $this->getTokenHeaders(),
            'json' => [
                'ids' => $subscribers
            ]
        ]);
    }
}