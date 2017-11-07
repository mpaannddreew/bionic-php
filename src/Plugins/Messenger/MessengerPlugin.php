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
use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\AbstractEndPoint;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\AbstractAttachment;
use Andre\Bionic\Plugins\Messenger\Messages\Message\AbstractSenderAction;
use Andre\Bionic\Plugins\Messenger\Messages\Message\MarkSeen;
use Andre\Bionic\Plugins\Messenger\Messages\Message\TypingOff;
use Andre\Bionic\Plugins\Messenger\Messages\Message\TypingOn;
use Andre\Bionic\Plugins\Messenger\Messages\Text;
use Andre\Bionic\Plugins\Messenger\Traits\AccessesUserProfile;
use Andre\Bionic\Plugins\Messenger\Traits\ManagesBotProfile;
use GuzzleHttp\Client as HttpClient;


class MessengerPlugin extends AbstractBionicPlugin
{
    use AccessesUserProfile, ManagesBotProfile;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $messaging_url = "https://graph.facebook.com/v2.10/me/messages?access_token=";

    /**
     * @var $page_access_token
     */
    protected $page_access_token;

    /**
     * MessengerPlugin constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->httpClient = $this->newHttpClient();
    }

    /**
     * @param mixed $page_access_token
     */
    public function setPageAccessToken($page_access_token)
    {
        $this->page_access_token = $page_access_token;
    }

    /**
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
        $this->webHookEvent = new MessengerWebHookEvent($this->webHookData);
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
     * send plain text
     *
     * @param string $text
     * @param array $quick_replies
     * @param AbstractEndPoint $recipient
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendPlainText($text, $quick_replies = [], AbstractEndPoint $recipient)
    {
        return $this->sendText(new Text(['text' => $text]), $quick_replies, $recipient);
    }

    /**
     * send text message
     *
     * @param Text $message
     * @param array $quick_replies
     * @param AbstractEndPoint $recipient
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendText(Text $message, $quick_replies = [], AbstractEndPoint $recipient)
    {
        $data = [
            'recipient' => $recipient->toArray(),
            'message' => $message->toArray()
        ];

        if ($quick_replies)
            $data['message']['quick_replies'] = $quick_replies;

        return $this->sendMessage($data);
    }

    /**
     * send an attachment message
     *
     * @param AbstractAttachment $message
     * @param AbstractEndPoint $recipient
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendAttachment(AbstractAttachment $message, AbstractEndPoint $recipient)
    {
        return $this->sendMessage([
            'recipient' => $recipient->toArray(),
            'message' => [
                'attachment' => $message->toArray()
            ]
        ]);
    }

    /**
     * send action
     *
     * @param AbstractEndPoint $recipient
     * @param string $type
     */
    public function sendAction(AbstractEndPoint $recipient, $type = 'mark_seen'){
        switch ($type)
        {
            case 'typing_off':
                $action = new TypingOff();
                break;
            case 'typing_on':
                $action = new TypingOn();
                break;
            default:
                $action = new MarkSeen();
                break;
        }

        $this->sendSenderAction($action, $recipient);
    }

    /**
     * send sender action
     *
     * @param AbstractSenderAction $message
     * @param AbstractEndPoint $recipient
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendSenderAction(AbstractSenderAction $message, AbstractEndPoint $recipient)
    {
        return $this->sendMessage(array_merge(['recipient' => $recipient->toArray()], $message->toArray()));
    }

    /**
     * send message
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendMessage($data)
    {
        return $this->httpClient->post($this->messaging_url . $this->page_access_token, ['json' => $data]);
    }
}
