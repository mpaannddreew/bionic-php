<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 7:28 PM
 */

namespace Andre\Bionic\Plugins\Telegram;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Telegram\Messages\Animation;
use Andre\Bionic\Plugins\Telegram\Messages\Audio;
use Andre\Bionic\Plugins\Telegram\Messages\Contact;
use Andre\Bionic\Plugins\Telegram\Messages\Dice;
use Andre\Bionic\Plugins\Telegram\Messages\Document;
use Andre\Bionic\Plugins\Telegram\Messages\Game;
use Andre\Bionic\Plugins\Telegram\Messages\Location;
use Andre\Bionic\Plugins\Telegram\Messages\Text;
use Andre\Bionic\Plugins\Telegram\Messages\Venue;
use Andre\Bionic\Plugins\Telegram\Messages\Video;
use Andre\Bionic\Plugins\Telegram\Messages\VideoNote;
use Andre\Bionic\Plugins\Telegram\Messages\Voice;

class Message extends AbstractMessage
{
    /**
     * @var int $message_id
     */
    protected $message_id;

    /**
     * @var array $from
     */
    protected $from = [];

    /**
     * @var int $date
     */
    protected $date;

    /**
     * @var array $chat
     */
    protected $chat = [];

    /**
     * @var array $forward_from
     */
    protected $forward_from = [];

    /**
     * @var array $forward_from_chat
     */
    protected $forward_from_chat = [];

    /**
     * @var int $forward_from_message_id
     */
    protected $forward_from_message_id;

    /**
     * @var string $forward_signature
     */
    protected $forward_signature;

    /**
     * @var string $forward_sender_name
     */
    protected $forward_sender_name;

    /**
     * @var int $forward_date
     */
    protected $forward_date;

    /**
     * @var array $reply_to_message
     */
    protected $reply_to_message = [];

    /**
     * @var int $edit_date
     */
    protected $edit_date;

    /**
     * @var string $media_group_id
     */
    protected $media_group_id;

    /**
     * @var string $author_signature
     */
    protected $author_signature;

    /**
     * @var string $text
     */
    protected $text;

    /**
     * @var array $entities
     */
    protected $entities = [];

    /**
     * @var array $animation
     */
    protected $animation = [];

    /**
     * @var array $audio
     */
    protected $audio = [];

    /**
     * @var array $document
     */
    protected $document = [];

    /**
     * @var array $photo
     */
    protected  $photo = [];

    /**
     * @var array $sticker
     */
    protected $sticker = [];

    /**
     * @var array $video
     */
    protected $video = [];

    /**
     * @var array $video_note
     */
    protected $video_note = [];

    /**
     * @var array $voice
     */
    protected $voice = [];

    /**
     * @var string $caption
     */
    protected $caption;

    /**
     * @var array $caption_entities
     */
    protected $caption_entities = [];

    /**
     * @var array $contact
     */
    protected $contact = [];

    /**
     * @var array $dice
     */
    protected $dice = [];

    /**
     * @var array $game
     */
    protected $game = [];

    /**
     * @var array $poll
     */
    protected $poll = [];

    /**
     * @var array $venue
     */
    protected $venue = [];

    /**
     * @var array $location
     */
    protected $location = [];

    /**
     * @var array $new_chat_members
     */
    protected $new_chat_members = [];

    /**
     * @var array $left_chat_member
     */
    protected $left_chat_member = [];

    /**
     * @var string $new_chat_title
     */
    protected $new_chat_title;

    /**
     * @var array $new_chat_photo
     */
    protected $new_chat_photo = [];

    /**
     * @var boolean $delete_chat_photo
     */
    protected $delete_chat_photo;

    /**
     * @var boolean $group_chat_created
     */
    protected $group_chat_created;

    /**
     * @var boolean $supergroup_chat_created
     */
    protected $supergroup_chat_created;

    /**
     * @var boolean $channel_chat_created
     */
    protected $channel_chat_created;

    /**
     * @var int $migrate_to_chat_id
     */
    protected $migrate_to_chat_id;

    /**
     * @var int $migrate_from_chat_id
     */
    protected $migrate_from_chat_id;

    /**
     * @var array $pinned_message
     */
    protected $pinned_message = [];

    /**
     * @var array $invoice
     */
    protected $invoice = [];

    /**
     * @var array $successful_payment
     */
    protected $successful_payment = [];

    /**
     * @var string $connected_website
     */
    protected $connected_website;

    /**
     * @var array $passport_data
     */
    protected $passport_data = [];

    /**
     * @var array $reply_markup
     */
    protected $reply_markup = [];

    /**
     * @return int
     */
    public function getMessageId()
    {
        return $this->message_id;
    }

    /**
     * @return User
     */
    public function getFrom()
    {
        if ($this->from) {
            return User::create($this->from);
        }

        return null;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return Chat
     */
    public function getChat()
    {
        if ($this->chat) {
            return Chat::create($this->chat);
        }

        return null;
    }

    /**
     * @return User
     */
    public function getForwardFrom()
    {
        if ($this->forward_from) {
            return User::create($this->forward_from);
        }

        return null;
    }

    /**
     * @return Chat
     */
    public function getForwardFromChat()
    {
        if ($this->forward_from_chat) {
            return Chat::create($this->forward_from_chat);
        }

        return null;
    }

    /**
     * @return int
     */
    public function getForwardFromMessageId()
    {
        return $this->forward_from_message_id;
    }

    /**
     * @return string
     */
    public function getForwardSignature()
    {
        return $this->forward_signature;
    }

    /**
     * @return string
     */
    public function getForwardSenderName()
    {
        return $this->forward_sender_name;
    }

    /**
     * @return int
     */
    public function getForwardDate()
    {
        return $this->forward_date;
    }

    /**
     * @return Message
     */
    public function getReplyToMessage()
    {
        if ($this->reply_to_message) {
            return self::create($this->reply_to_message);
        }

        return null;
    }

    /**
     * @return int
     */
    public function getEditDate()
    {
        return $this->edit_date;
    }

    /**
     * @return string
     */
    public function getMediaGroupId()
    {
        return $this->media_group_id;
    }

    /**
     * @return string
     */
    public function getAuthorSignature()
    {
        return $this->author_signature;
    }

    /**
     * @return string
     */
    public function getText()
    {
        if ($this->text != null) {
            return Text::create(['text' => $this->text]);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        if ($this->entities) {
            $entities = [];
            foreach ($this->entities as $entity) {
                array_push($entities, MessageEntity::create($entity));
            }

            return $entities;
        }

        return null;
    }

    /**
     * @return Animation
     */
    public function getAnimation()
    {
        if ($this->animation) {
            return Animation::create($this->animation);
        }

        return null;
    }

    /**
     * @return Audio
     */
    public function getAudio()
    {
        if ($this->audio) {
            return Audio::create($this->audio);
        }

        return null;
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        if ($this->document) {
            return Document::create($this->document);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getPhoto()
    {
        if ($this->photo) {
            $photo = [];
            foreach ($this->photo as $item) {
                array_push($photo, PhotoSize::create($item));
            }

            return $photo;
        }

        return null;
    }

    /**
     * @return array
     */
    public function getSticker()
    {
        return $this->sticker;
    }

    /**
     * @return Video
     */
    public function getVideo()
    {
        if ($this->video) {
            return Video::create($this->video);
        }

        return null;
    }

    /**
     * @return VideoNote
     */
    public function getVideoNote()
    {
        if ($this->video_note) {
            return VideoNote::create($this->video_note);
        }

        return null;
    }

    /**
     * @return Voice
     */
    public function getVoice()
    {
        if ($this->voice) {
            return Voice::create($this->voice);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return array
     */
    public function getCaptionEntities()
    {
        if ($this->caption_entities) {
            $entities = [];
            foreach ($this->caption_entities as $entity) {
                array_push($entities, MessageEntity::create($entities));
            }

            return $entities;
        }

        return null;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        if ($this->contact) {
            return Contact::create($this->contact);
        }

        return null;
    }

    /**
     * @return Dice
     */
    public function getDice()
    {
        if ($this->dice) {
            return Dice::create($this->dice);
        }

        return null;
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        if ($this->game) {
            return Game::create($this->game);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * @return Venue
     */
    public function getVenue()
    {
        if ($this->venue) {
            return Venue::create($this->venue);
        }

        return null;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        if ($this->location) {
            return Location::create($this->location);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getNewChatMembers()
    {
        if ($this->new_chat_members) {
            $users = [];
            foreach ($this->new_chat_members as $member) {
                array_push($users, User::create($member));
            }

            return $users;
        }

        return null;
    }

    /**
     * @return User
     */
    public function getLeftChatMember()
    {
        if ($this->left_chat_member) {
            return User::create($this->left_chat_member);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getNewChatTitle()
    {
        return $this->new_chat_title;
    }

    /**
     * @return array
     */
    public function getNewChatPhoto()
    {
        if ($this->new_chat_photo) {
            $photos = [];
            foreach ($this->new_chat_photo as $item) {
                array_push($photos, PhotoSize::create($item));
            }

            return $photos;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isDeleteChatPhoto()
    {
        return $this->delete_chat_photo;
    }

    /**
     * @return bool
     */
    public function isGroupChatCreated()
    {
        return $this->group_chat_created;
    }

    /**
     * @return bool
     */
    public function isSupergroupChatCreated()
    {
        return $this->supergroup_chat_created;
    }

    /**
     * @return bool
     */
    public function isChannelChatCreated()
    {
        return $this->channel_chat_created;
    }

    /**
     * @return int
     */
    public function getMigrateToChatId()
    {
        return $this->migrate_to_chat_id;
    }

    /**
     * @return int
     */
    public function getMigrateFromChatId()
    {
        return $this->migrate_from_chat_id;
    }

    /**
     * @return Message
     */
    public function getPinnedMessage()
    {
        if ($this->pinned_message) {
            return self::create($this->pinned_message);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return array
     */
    public function getSuccessfulPayment()
    {
        return $this->successful_payment;
    }

    /**
     * @return string
     */
    public function getConnectedWebsite()
    {
        return $this->connected_website;
    }

    /**
     * @return array
     */
    public function getPassportData()
    {
        return $this->passport_data;
    }

    /**
     * @return array
     */
    public function getReplyMarkup()
    {
        return $this->reply_markup;
    }
}