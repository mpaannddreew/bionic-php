<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:30 AM
 */

namespace Andre\Bionic\Plugins\Messenger;


use Andre\Bionic\AbstractBionicClient;
use Andre\Bionic\Plugins\AbstractBionicPlugin;

class MessengerPlugin extends AbstractBionicPlugin
{
    /**
     * @var $page_access_token
     */
    protected $page_access_token;

    /**
     * @param AbstractBionicClient $client
     */
    public function emitEvents(AbstractBionicClient $client)
    {
        $this->client = $client;
        $this->runClientTasks();
        $this->client->emit('message.number', [$this->client, 3]);
    }

    /**
     * @return array
     */
    protected function getClientOptions()
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false
        ];
    }
}
