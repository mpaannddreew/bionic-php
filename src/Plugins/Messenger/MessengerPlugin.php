<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:30 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger;


use Andre\Bionic\AbstractBionic;
use Andre\Bionic\Plugins\AbstractBionicPlugin;
use Andre\Bionic\Plugins\Messenger\Traits\AccessesUserProfile;
use Andre\Bionic\Plugins\Messenger\Traits\ManagesBotProfile;
use Andre\Bionic\Plugins\Messenger\Traits\SendsMessages;
use GuzzleHttp\Client as HttpClient;


class MessengerPlugin extends AbstractBionicPlugin
{
    use AccessesUserProfile, ManagesBotProfile, SendsMessages;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var $page_access_token
     */
    protected $page_access_token;

    /**
     * create new messenger plugin instance
     *
     * MessengerPlugin constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->httpClient = $this->newHttpClient();
    }

    /**
     * set new page access token
     *
     * @param string $page_access_token
     */
    public function setPageAccessToken($page_access_token)
    {
        $this->page_access_token = $page_access_token;
    }

    /**
     * emit events
     *
     * @param AbstractBionic $bionic
     */
    public function emitEvents(AbstractBionic $bionic)
    {
        $this->bionic = $bionic;
        $this->runPluginTasks();
        $this->iterateOverEntryMessagesAndEmitEvents();
    }

    /**
     * create new http client
     *
     * @return HttpClient
     */
    protected function newHttpClient()
    {
        return new HttpClient([
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'verify' => false
        ]);
    }

    /**
     * create a new web hook event from web hook data
     */
    protected function createWebHookEvent()
    {
        $this->webHookEvent = MessengerWebHookEvent::create($this->webHookData);
    }

    /**
     * iterate over web hook event entry items
     */
    protected function iterateOverEntryMessagesAndEmitEvents()
    {
        if ($entryItems = $this->webHookEvent->getEntryItems())
            $this->bionic->emit('entry', [$this, $entryItems]);

        foreach ($this->webHookEvent->getEntryItems() as $entryItem)
        {
            $this->bionic->emit('entry.item', [$this, $entryItem]);

            if ($messagingItems = $entryItem->getMessagingItems())
                $this->bionic->emit('messaging', [$this, $messagingItems]);

            foreach ($entryItem->getMessagingItems() as $messagingItem)
            {
                $this->bionic->emit('messaging.item', [$this, $messagingItem]);

                $sender = $messagingItem->getSender();
                $recipient = $messagingItem->getRecipient();

                if ($message = $messagingItem->getMessage()){

                    if ($message->isEcho())
                    {
                        $this->bionic->emit('message.echo', [$this, $sender, $recipient, $message]);
                    }else {
                        $this->bionic->emit('message', [$this, $sender, $recipient, $message]);

                        if ($message->getText())
                            $this->bionic->emit('message.text', [$this, $sender, $recipient, $message->getText(), $message->getQuickReply()]);

                        if ($attachments = $message->getAttachmentItems())
                        {
                            $this->bionic->emit('message.attachments', [$this, $sender, $recipient, $attachments]);

                            foreach ($attachments as $attachment)
                            {
                                $this->bionic->emit('message.attachments.' . $attachment->getType(), [$this, $sender, $recipient, $attachment]);
                            }
                        }
                    }
                }

                if ($post_back = $messagingItem->getPostback())
                    $this->bionic->emit('postback', [$this, $sender, $recipient, $post_back]);

                if ($referral = $messagingItem->getReferral())
                    $this->bionic->emit('referral', [$this, $sender, $recipient, $referral]);

                if ($optin = $messagingItem->getOptin())
                    $this->bionic->emit('optin', [$this, $sender, $recipient, $optin]);

                if ($account_linking = $messagingItem->getAccountLinking())
                    $this->bionic->emit('account_linking', [$this, $sender, $recipient, $account_linking]);

                if ($delivery = $messagingItem->getDelivery())
                    $this->bionic->emit('delivery', [$this, $sender, $recipient, $delivery]);

                if ($read = $messagingItem->getRead())
                    $this->bionic->emit('read', [$this, $sender, $recipient, $read]);
            }
        }
    }

    /**
     * check if page access token has been provided before making any http request
     */
    protected function checkForPageAccessToken()
    {
        if (!$this->page_access_token)
            throw new \InvalidArgumentException('A facebook page access token has not been specified!');
    }
}
