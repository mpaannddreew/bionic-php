<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 12:50 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Audio;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Fallback;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\File;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Location;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Video;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Nlp;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Andre\Bionic\Plugins\Messenger\Messages\Message\ReplyTo;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Text;
use Exception;

class Message extends AbstractMessage
{
    /**
     * @var string $mid
     */
    protected $mid;

    /**
     * @var string $text
     */
    protected $text;

    /**
     * @var int $seq
     */
    protected $seq;

    /**
     * @var boolean $is_echo
     */
    protected $is_echo = False;

    /**
     * @var int $app_id
     */
    protected $app_id;

    /**
     * @var string $metadata
     */
    protected $metadata;

    /**
     * @var array $quick_reply
     */
    protected $quick_reply = [];

    /**
     * @var array $reply_to
     */
    protected $reply_to = [];

    /**
     * @var array $attachments
     */
    protected $attachments = [];

    /**
     * @var array $attachment_items
     */
    protected $attachment_items = [];

    /**
     * @var array $nlp
     */
    protected $nlp = [];

    /**
     * Message constructor.
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->populateAttachmentItems();
    }

    /**
     * populate messaging items
     */
    protected function populateAttachmentItems()
    {
        foreach ($this->attachments as $attachment_item)
        {
            switch ($attachment_item['type']){
                case 'location':
                    $attachment = Location::create($attachment_item);
                    break;
                case 'file':
                    $attachment = File::create($attachment_item);
                    break;
                case 'audio':
                    $attachment = Audio::create($attachment_item);
                    break;
                case 'Video':
                    $attachment = Video::create($attachment_item);
                    break;
                case 'image':
                    $attachment = Image::create($attachment_item);
                    break;
                case 'fallback':
                    $attachment = Fallback::create($attachment_item);
                    break;
                default:
                    break;
            }

            try{
                array_push($this->attachment_items, $attachment);
            }catch (Exception $exception){}
        }
    }

    /**
     * get mid
     *
     * @return int mixed
     */
    public function getMid()
    {
        return $this->mid;
    }

    /**
     * get text
     *
     * @return Text
     */
    public function getText()
    {
        if ($this->text)
            return Text::create()->setText($this->text);

        return null;
    }

    /**
     * get quick reply
     *
     * @return QuickReply|null
     */
    public function getQuickReply()
    {
        if ($this->quick_reply)
            return QuickReply::create($this->quick_reply);

        return null;
    }

    /**
     * get reply to
     *
     * @return null|ReplyTo
     */
    public function getReplyTo()
    {
        if ($this->reply_to)
            return ReplyTo::create($this->reply_to);

        return null;
    }

    /**
     * get nlp
     *
     * @return Nlp|null
     */
    public function getNlp()
    {
        if ($this->nlp)
            return Nlp::create($this->nlp);

        return null;
    }

    /**
     * get attachments
     *
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * get attanchment items
     *
     * @return array
     */
    public function getAttachmentItems()
    {
        return $this->attachment_items;
    }

    /**
     * if message was echoed
     *
     * @return bool
     */
    public function isEcho()
    {
        return $this->is_echo;
    }

    /**
     * get app id
     *
     * @return int
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * get metadata
     *
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * get seq
     *
     * @return int
     */
    public function getSeq()
    {
        return $this->seq;
    }
}