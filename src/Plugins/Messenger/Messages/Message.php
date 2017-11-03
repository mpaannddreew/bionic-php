<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 12:50 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Audio;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Fallback;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\File;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Image;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Location;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Video;
use Andre\Bionic\Plugins\Messenger\Messages\Message\QuickReply;
use Exception;

class Message extends AbstractMessage
{
    /**
     * @var $mid
     */
    protected $mid;

    /**
     * @var $text
     */
    protected $text;

    /**
     * @var boolean $is_echo
     */
    protected $is_echo = False;

    /**
     * @var $app_id
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
     * @var array $attachments
     */
    protected $attachments = [];

    /**
     * @var array $attachment_items
     */
    protected $attachment_items = [];

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
                    $attachment = new Location($attachment_item);
                    break;
                case 'file':
                    $attachment = new File($attachment_item);
                    break;
                case 'audio':
                    $attachment = new Audio($attachment_item);
                    break;
                case 'Video':
                    $attachment = new Video($attachment_item);
                    break;
                case 'image':
                    $attachment = new Image($attachment_item);
                    break;
                case 'fallback':
                    $attachment = new Fallback($attachment_item);
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
     * @return mixed
     */
    public function getMid()
    {
        return $this->mid;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return QuickReply
     */
    public function getQuickReply()
    {
        return new QuickReply($this->quick_reply);
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @return array
     */
    public function getAttachmentItems()
    {
        return $this->attachment_items;
    }

    /**
     * @return bool
     */
    public function isEcho()
    {
        return $this->is_echo;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}