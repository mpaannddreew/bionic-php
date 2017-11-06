<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 2:35 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Traits;


use Andre\Bionic\Plugins\Messenger\BotProfile\GetStarted;
use Andre\Bionic\Plugins\Messenger\BotProfile\PersistentMenu;

trait ManagesBotProfile
{

    /**
     * @var string $messenger_profile_url
     */
    protected $messenger_profile_url = "https://graph.facebook.com/v2.6/me/messenger_profile?access_token=";

    /**
     * set greeting
     *
     * @param array $greetings
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setGreeting($greetings = [])
    {
        return $this->setProperty([
            'greeting' => $greetings
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
     * @param PersistentMenu $persistentMenu
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setPersistentMenu(PersistentMenu $persistentMenu)
    {
        return $this->setProperty([
            'persistent_menu' => [$persistentMenu->toArray()]
        ]);
    }

    /**
     * set properties
     *
     * @param array $greetings
     * @param GetStarted|null $getStarted
     * @param array $domains
     * @param PersistentMenu|null $persistentMenu
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setProperties($greetings = [], GetStarted $getStarted = null, $domains = [], PersistentMenu $persistentMenu = null)
    {
        $data = [];

        if ($greetings)
            $data['greeting'] = $greetings;

        if ($getStarted)
            $data['get_started'] = $getStarted->toArray();

        if ($domains)
            $data['whitelisted_domains'] = $domains;

        if ($persistentMenu)
            $data['persistent_menu'] = $persistentMenu->toArray();

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
        return $this->httpClient->post($this->messenger_profile_url . $this->page_access_token, ['json' => $data]);
    }

    /**
     * set property
     *
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function deleteProperty($data)
    {
        return $this->httpClient->delete($this->messenger_profile_url . $this->page_access_token, ['json' => $data]);
    }
}