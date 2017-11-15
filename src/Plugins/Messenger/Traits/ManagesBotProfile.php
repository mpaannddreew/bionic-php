<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 2:35 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Traits;


use Andre\Bionic\Plugins\Messenger\BotProfile\GetStarted;

trait ManagesBotProfile
{

    /**
     * @var string $messenger_profile_url
     */
    protected $messenger_profile_url = "https://graph.facebook.com/%s/me/messenger_profile?access_token=%s";

    /**
     * set privacy policy URL
     *
     * @param $privacy_url
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setPrivacyUrl($privacy_url)
    {
        return $this->setProperty([
            'payment_settings' => [
                'privacy_url' => $privacy_url
            ]
        ]);
    }

    /**
     * set public key
     *
     * @param $public_key
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setPublicKey($public_key)
    {
        return $this->setProperty([
            'payment_settings' => [
                'public_key' => $public_key
            ]
        ]);
    }

    /**
     * set greeting
     *
     * @param array $greetings
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setGreetingText($greetings = [])
    {
        $data = [];
        foreach ($greetings as $greeting){
            array_push($data, $greeting->toArray());
        }

        return $this->setProperty([
            'greeting' => $data
        ]);
    }

    /**
     * set get started button
     *
     * @param GetStarted $getStarted
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setGetStarted(GetStarted $getStarted)
    {
        return $this->setProperty([
            'get_started' => $getStarted->toArray()
        ]);
    }

    /**
     * whitelist domains
     *
     * @param array $domains
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function whitelistDomains($domains = [])
    {
        return $this->setProperty([
            'whitelisted_domains' => $domains
        ]);
    }

    /**
     * set persistent menu
     *
     * @param array $persistent_menus
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setPersistentMenu($persistent_menus = [])
    {
        $data = [];
        foreach ($persistent_menus as $persistentMenu){
            array_push($data, $persistentMenu->toArray());
        }

        return $this->setProperty([
            'persistent_menu' => $data
        ]);
    }

    /**
     * set properties
     *
     * @param array $greetings
     * @param GetStarted|null $getStarted
     * @param array $domains
     * @param array $persistent_menus
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setProperties($greetings = [], GetStarted $getStarted = null, $domains = [], $persistent_menus = [])
    {
        $data = [];

        if ($greetings) {
            $_data = [];
            foreach ($greetings as $greeting){
                array_push($_data, $greeting->toArray());
            }
            $data['greeting'] = $_data;
        }

        if ($getStarted)
            $data['get_started'] = $getStarted->toArray();

        if ($domains)
            $data['whitelisted_domains'] = $domains;

        if ($persistent_menus){
            $_data = [];
            foreach ($persistent_menus as $persistent_menu){
                array_push($_data, $persistent_menu->toArray());
            }
            $data['persistent_menu'] = $_data;
        }

        return $this->setProperty($data);
    }

    /**
     * delete properties
     *
     * @param array $properties
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteProperties($properties = [])
    {
        return $this->deleteProperty(['fields' => $properties]);
    }

    /**
     * set property
     *
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setProperty($data)
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        return $this->httpClient->post($this->messengerProfileFullUrl(), ['json' => $data]);
    }

    /**
     * set property
     *
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function deleteProperty($data)
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        return $this->httpClient->delete($this->messengerProfileFullUrl(), ['json' => $data]);
    }

    /**
     * messenger profile full url
     *
     * @return string
     */
    protected function messengerProfileFullUrl()
    {
        return sprintf($this->messenger_profile_url, $this->graph_api_version, $this->page_access_token);
    }
}