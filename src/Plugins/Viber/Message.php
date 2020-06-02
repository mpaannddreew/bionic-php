<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 9:08 PM
 */

namespace Andre\Bionic\Plugins\Viber;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Viber\Messages\Contact;
use Andre\Bionic\Plugins\Viber\Messages\File;
use Andre\Bionic\Plugins\Viber\Messages\Image;
use Andre\Bionic\Plugins\Viber\Messages\Location;
use Andre\Bionic\Plugins\Viber\Messages\Text;
use Andre\Bionic\Plugins\Viber\Messages\Url;
use Andre\Bionic\Plugins\Viber\Messages\Video;

class Message extends AbstractMessage
{
    /**
     * @var string $type
     */
    protected $type;

    /**
     * @var string $text
     */
    protected $text;

    /**
     * @var string $media
     */
    protected $media;

    /**
     * @var array $location
     */
    protected $location = [];

    /**
     * @var array $contact
     */
    protected $contact = [];

    /**
     * @var string $tracking_data
     */
    protected $tracking_data;

    /**
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @var int $file_size
     */
    protected $file_size;

    /**
     * @var int $duration
     */
    protected $duration;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTrackingData()
    {
        return $this->tracking_data;
    }

    /**
     * @return Text|null
     */
    public function getText() {
        if ($this->type === 'text') {
            return Text::create(['text' => $this->text]);
        }

        return null;
    }

    /**
     * @return Image|null
     */
    public function getImage() {
        if ($this->type === 'picture') {
            return Image::create(['text' => $this->text, 'media' => $this->media]);
        }

        return null;
    }

    /**
     * @return Url|null
     */
    public function getUrl() {
        if ($this->type === 'url') {
            return Url::create(['media' => $this->media]);
        }

        return null;
    }

    /**
     * @return Location|null
     */
    public function getLocation() {
        if ($this->location) {
            return Location::create($this->location);
        }

        return null;
    }

    /**
     * @return Contact|null
     */
    public function getContact() {
        if ($this->contact) {
            return Contact::create($this->contact);
        }

        return null;
    }

    /**
     * @return Video|null
     */
    public function getVideo() {
        if ($this->type === 'video') {
            return Video::create(['duration' => $this->duration, 'media' => $this->media]);
        }

        return null;
    }

    /**
     * @return File|null
     */
    public function getFile() {
        if ($this->type === 'file') {
            return File::create(['size' => $this->file_size, 'media' => $this->media, 'file_name' => $this->file_name]);
        }

        return null;
    }
}