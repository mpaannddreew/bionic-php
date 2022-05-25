<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 8:51 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\WhatsApp\Messages\Document;
use Andre\Bionic\Plugins\WhatsApp\Messages\Image;
use Andre\Bionic\Plugins\WhatsApp\Messages\Location;
use Andre\Bionic\Plugins\WhatsApp\Messages\Sticker;
use Andre\Bionic\Plugins\WhatsApp\Messages\System;
use Andre\Bionic\Plugins\WhatsApp\Messages\Text;
use Andre\Bionic\Plugins\WhatsApp\Messages\Voice;

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

    protected $voice = [];

    protected $sticker = [];

    protected $system = [];

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
    public function getContext() {
        if ($this->context) {
            return Context::create($this->context);
        }

        return null;
    }

    /**
     * @return null|Text
     */
    public function getText() {
        if ($this->text) {
            return Text::create($this->text);
        }

        return null;
    }

    /**
     * @return null|Location
     */
    public function getLocation() {
        if ($this->location) {
            return Location::create($this->location);
        }
        return null;
    }

    public function getContacts() {
        if ($this->contacts) {
            return $this->contacts;
        }

        return null;
    }

    public function getErrors() {
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
    public function getImage() {
        if ($this->image) {
            return Image::create($this->image);
        }

        return null;
    }

    /**
     * @return null|Document
     */
    public function getDocument() {
        if ($this->document) {
            return Document::create($this->document);
        }

        return null;
    }

    /**
     * @return null|Voice
     */
    public function getVoice() {
        if ($this->voice) {
            return Voice::create($this->voice);
        }

        return null;
    }

    /**
     * @return null|Sticker
     */
    public function getSticker() {
        if ($this->sticker) {
            return Sticker::create($this->sticker);
        }

        return null;
    }

    /**
     * @return null|System
     */
    public function getSystem() {
        if ($this->system) {
            return System::create($this->system);
        }

        return null;
    }
}