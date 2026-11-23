<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp;

use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\WhatsApp\Messages\Button;
use Andre\Bionic\Plugins\WhatsApp\Messages\Document;
use Andre\Bionic\Plugins\WhatsApp\Messages\Image;
use Andre\Bionic\Plugins\WhatsApp\Messages\Interactive;
use Andre\Bionic\Plugins\WhatsApp\Messages\Location;
use Andre\Bionic\Plugins\WhatsApp\Messages\Sticker;
use Andre\Bionic\Plugins\WhatsApp\Messages\System;
use Andre\Bionic\Plugins\WhatsApp\Messages\Text;
use Andre\Bionic\Plugins\WhatsApp\Messages\Audio;
use Andre\Bionic\Plugins\WhatsApp\Messages\Video;

class Message extends AbstractMessage
{
    protected $from;

    protected $group_id;

    protected $id;

    protected $timestamp;

    protected $type;

    protected $context = [];

    protected $text = [];

    protected $location = [];

    protected $contacts = [];

    protected $errors = [];

    protected $image = [];

    protected $document = [];

    protected $audio = [];

    protected $video = [];

    protected $sticker = [];

    protected $system = [];

    /**
     * @var string
     */
    protected $from_user_id;

    /**
     * @var array
     */
    protected $interactive = [];

    /**
     * @var array
     */
    protected $button = [];

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return null|Context
     */
    public function getContext()
    {
        if ($this->context) {
            return Context::create($this->context);
        }

        return null;
    }

    /**
     * @return null|Text
     */
    public function getText()
    {
        if ($this->text) {
            return Text::create($this->text);
        }

        return null;
    }

    /**
     * @return null|Location
     */
    public function getLocation()
    {
        if ($this->location) {
            return Location::create($this->location);
        }
        return null;
    }

    public function getContacts()
    {
        if ($this->contacts) {
            return $this->contacts;
        }

        return null;
    }

    public function getErrors()
    {
        if ($this->errors) {
            $errors = [];
            foreach ($this->errors as $error) {
                array_push($errors, Error::create($error));
            }
            return $errors;
        }

        return null;
    }

    /**
     * @return null|Image
     */
    public function getImage()
    {
        if ($this->image) {
            return Image::create($this->image);
        }

        return null;
    }

    /**
     * @return null|Document
     */
    public function getDocument()
    {
        if ($this->document) {
            return Document::create($this->document);
        }

        return null;
    }

    /**
     * @return null|Video
     */
    public function getVideo()
    {
        if ($this->video) {
            return Video::create($this->video);
        }

        return null;
    }

    /**
     * @return null|Audio
     */
    public function getAudio()
    {
        if ($this->audio) {
            return Audio::create($this->audio);
        }

        return null;
    }

    /**
     * @return null|Sticker
     */
    public function getSticker()
    {
        if ($this->sticker) {
            return Sticker::create($this->sticker);
        }

        return null;
    }

    /**
     * @return null|System
     */
    public function getSystem()
    {
        if ($this->system) {
            return System::create($this->system);
        }

        return null;
    }

    /**
     * The sender's business-scoped user ID (BSUID)
     *
     * @return string|null
     */
    public function getFromUserId()
    {
        return $this->from_user_id;
    }

    /**
     * A reply to an interactive (button or list) message
     *
     * @return null|Interactive
     */
    public function getInteractive()
    {
        if ($this->interactive) {
            return Interactive::create($this->interactive);
        }

        return null;
    }

    /**
     * A tap on a template's quick-reply button
     *
     * @return null|Button
     */
    public function getButton()
    {
        if ($this->button) {
            return Button::create($this->button);
        }

        return null;
    }
}
