<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-08
 * Time: 1:07 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Traits;

use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\AbstractEndPoint;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\AbstractAttachment;
use Andre\Bionic\Plugins\Messenger\Messages\Message\AbstractSenderAction;
use Andre\Bionic\Plugins\Messenger\Messages\Message\MarkSeen;
use Andre\Bionic\Plugins\Messenger\Messages\Message\TypingOff;
use Andre\Bionic\Plugins\Messenger\Messages\Message\TypingOn;
use Andre\Bionic\Plugins\Messenger\Messages\Text;

trait SendsMessages
{

    /**
     * @var string
     */
    protected $messaging_url = "https://graph.facebook.com/v2.10/me/messages?access_token=";

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
        return $this->sendText(Text::create(['text' => $text]), $quick_replies, $recipient);
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
        {
            $data['message']['quick_replies'] = [];
            foreach ($quick_replies as $quick_reply){
                array_push($data['message']['quick_replies'], $quick_reply->toArray());
            }
        }

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
                $action = TypingOff::create();
                break;
            case 'typing_on':
                $action = TypingOn::create();
                break;
            default:
                $action = MarkSeen::create();
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
     *
     * @param $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendMessage($data)
    {
        $this->checkForPageAccessToken();

        return $this->httpClient->post($this->messaging_url . $this->page_access_token, ['json' => $data]);
    }
}