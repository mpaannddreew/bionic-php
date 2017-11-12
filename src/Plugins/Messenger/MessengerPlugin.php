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
use Andre\Bionic\Plugins\Messenger\Messages\AbstractChannelItem;
use Andre\Bionic\Plugins\Messenger\Traits\AccessesUserProfile;
use Andre\Bionic\Plugins\Messenger\Traits\ManagesBotProfile;
use Andre\Bionic\Plugins\Messenger\Traits\PassesThreadControl;
use Andre\Bionic\Plugins\Messenger\Traits\SendsMessages;
use Andre\Bionic\Plugins\Messenger\Traits\TakesThreadControl;
use GuzzleHttp\Client as HttpClient;


class MessengerPlugin extends AbstractBionicPlugin
{
    use AccessesUserProfile, ManagesBotProfile, SendsMessages, PassesThreadControl, TakesThreadControl;

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

            if ($standbyItems = $entryItem->getStandbyItems())
                $this->bionic->emit('standby', [$this, $standbyItems]);

            if ($messagingItems = $entryItem->getMessagingItems())
                $this->bionic->emit('messaging', [$this, $messagingItems]);

            foreach ($entryItem->getStandbyItems() as $standbyItem)
            {
                $this->bionic->emit('standby.item', [$this, $standbyItem]);

                $this->emitAbstractChannelEvents($standbyItem, 'standby');
            }

            foreach ($entryItem->getMessagingItems() as $messagingItem)
            {
                $this->bionic->emit('messaging.item', [$this, $messagingItem]);

                $this->emitAbstractChannelEvents($messagingItem);

                $sender = $messagingItem->getSender();
                $recipient = $messagingItem->getRecipient();

                if ($post_back = $messagingItem->getPostback())
                    $this->bionic->emit('postback', [$this, $sender, $recipient, $post_back]);

                if ($referral = $messagingItem->getReferral())
                    $this->bionic->emit('referral', [$this, $sender, $recipient, $referral]);

                if ($optin = $messagingItem->getOptin())
                    $this->bionic->emit('optin', [$this, $sender, $recipient, $optin]);

                if ($account_linking = $messagingItem->getAccountLinking())
                    $this->bionic->emit('account_linking', [$this, $sender, $recipient, $account_linking]);

                if ($policy_enforcement = $messagingItem->getPolicyEnforcement())
                    $this->bionic->emit('policy_enforcement', [$this, $recipient, $policy_enforcement]);

                if ($payment = $messagingItem->getPayment())
                    $this->bionic->emit('payment', [$this, $sender, $recipient, $payment]);

                if ($checkout_update = $messagingItem->getCheckoutUpdate())
                    $this->bionic->emit('checkout_update', [$this, $sender, $recipient, $checkout_update]);

                if ($pre_checkout = $messagingItem->getPreCheckout())
                    $this->bionic->emit('pre_checkout', [$this, $sender, $recipient, $pre_checkout]);

                if ($pass_thread_control = $messagingItem->getPassThreadControl())
                    $this->bionic->emit('pass_thread_control', [$this, $sender, $recipient, $pass_thread_control]);

                if ($take_thread_control = $messagingItem->getTakeThreadControl())
                    $this->bionic->emit('take_thread_control', [$this, $sender, $recipient, $take_thread_control]);

                if ($app_roles = $messagingItem->getAppRoles())
                    $this->bionic->emit('app_roles', [$this, $recipient, $app_roles]);
            }
        }
    }

    /**
     * emit abstract channel events
     *
     * @param AbstractChannelItem $channelItem
     * @param string $channel
     */
    protected function emitAbstractChannelEvents(AbstractChannelItem $channelItem, $channel="messaging")
    {
        $sender = $channelItem->getSender();
        $recipient = $channelItem->getRecipient();

        if ($message = $channelItem->getMessage()){

            if ($message->isEcho())
            {
                $this->bionic->emit('message.echo', [$this, $sender, $recipient, $message]);
            }else {
                $this->bionic->emit('message', [$this, $sender, $recipient, $message, $channel]);

                if ($message->getText())
                    $this->bionic->emit('message.text', [$this, $sender, $recipient, $message->getText(), $message->getQuickReply(), $message->getNlp(), $channel]);

                if ($attachments = $message->getAttachmentItems())
                {
                    $this->bionic->emit('message.attachments', [$this, $sender, $recipient, $attachments, $channel]);

                    foreach ($attachments as $attachment)
                    {
                        $this->bionic->emit('message.attachments.' . $attachment->getType(), [$this, $sender, $recipient, $attachment, $channel]);
                    }
                }
            }
        }

        if ($delivery = $channelItem->getDelivery())
            $this->bionic->emit('delivery', [$this, $sender, $recipient, $delivery, $channel]);

        if ($read = $channelItem->getRead())
            $this->bionic->emit('read', [$this, $sender, $recipient, $read, $channel]);
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
