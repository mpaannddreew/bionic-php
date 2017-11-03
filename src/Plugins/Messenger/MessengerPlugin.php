<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:30 AM
 */

namespace Andre\Bionic\Plugins\Messenger;


use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Plugins\AbstractBionicPlugin;

class MessengerPlugin extends AbstractBionicPlugin
{
    /**
     * @var string
     */
    protected $url = "https://graph.facebook.com/v2.6/me/messages?access_token=";

    /**
     * @var $page_access_token
     */
    protected $page_access_token;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        if ($this->page_access_token)
            $this->editUrl($this->page_access_token);
    }

    /**
     * @param mixed $page_access_token
     */
    public function changePageAccessToken($page_access_token)
    {
        $this->page_access_token = $page_access_token;
        $this->editUrl($this->page_access_token);
    }

    protected function editUrl($page_access_token)
    {
        $this->url = $this->url . $page_access_token;
    }

    /**
     * @param AbstractBionic $client
     */
    public function emitEvents(AbstractBionic $client)
    {
        $this->client = $client;
        $this->runPluginTasks();
        $this->iterateOverEntryMessages();
    }

    /**
     * @return array
     */
    protected function defineHttpClientOptions()
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false
        ];
    }

    /**
     * create a new web hook event from web hook data
     */
    protected function createWebHookEvent()
    {
        $this->webHookEvent = new MessengerWebHookEvent($this->webHookData);
    }

    /**
     * iterate over web hook event entry items
     */
    protected function iterateOverEntryMessages()
    {
        if ($entryMessages = $this->webHookEvent->getEntryMessages())
            $this->client->emit('messenger.entry', [$this, $entryMessages]);

        foreach ($this->webHookEvent->getEntryMessages() as $entryMessage)
        {
            $this->client->emit('messenger.entry.message', [$this, $entryMessage]);

            foreach ($entryMessage->getMessagingItems() as $messagingItem)
            {
                $sender = $messagingItem->getSender();
                $recipient = $messagingItem->getRecipient();

                if ($messagingItem->getMessage()){
                    $message = $messagingItem->getMessage();
                    if ($message->isEcho())
                    {
                        $this->client->emit('messenger.entry.message.echo', [$this, $sender, $recipient, $message]);
                    }else {
                        if ($message->getText())
                            $this->client->emit('messenger.entry.message.text', [$this, $sender, $recipient, $message]);

                        if ($attachments = $message->getAttachmentItems())
                        {
                            $this->client->emit('messenger.entry.message.attachments', [$this, $sender, $recipient, $attachments]);
                            foreach ($attachments as $attachment)
                            {
                                $this->client->emit('messenger.entry.message.attachments.' . $attachment->getType(), [$this, $sender, $recipient, $attachment]);
                            }
                        }
                    }
                }

                if ($messagingItem->getPostback()){

                }

                if ($messagingItem->getReferral()){

                }

                if ($messagingItem->getOptin()){

                }

                if ($messagingItem->getAccountLinking()){

                }

                if ($messagingItem->getDelivery()){

                }
            }
        }
    }
}
