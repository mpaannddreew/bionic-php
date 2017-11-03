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

                if ($post_back = $messagingItem->getPostback()){
                    $this->client->emit('messenger.entry.postback', [$this, $sender, $recipient, $post_back]);
                }

                if ($referral = $messagingItem->getReferral()){
                    $this->client->emit('messenger.entry.referral', [$this, $sender, $recipient, $referral]);
                }

                if ($optin = $messagingItem->getOptin()){
                    $this->client->emit('messenger.entry.optin', [$this, $sender, $recipient, $optin]);
                }

                if ($account_linking = $messagingItem->getAccountLinking()){
                    $this->client->emit('messenger.entry.account_linking', [$this, $sender, $recipient, $account_linking]);
                }

                if ($delivery = $messagingItem->getDelivery()){
                    $this->client->emit('messenger.entry.delivery', [$this, $sender, $recipient, $delivery]);
                }

                if ($read = $messagingItem->getRead()){
                    $this->client->emit('messenger.entry.read', [$this, $sender, $recipient, $read]);
                }
            }
        }
    }
}
