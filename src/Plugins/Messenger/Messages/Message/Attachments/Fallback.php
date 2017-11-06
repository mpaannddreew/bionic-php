<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 4:26 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;



class Fallback extends AbstractAttachment
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $URL
     */
    protected $URL;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * set type
     */
    public function setType()
    {
        $this->type = self::FALLBACK;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->data['title'] = $this->getTitle();
        return $this;
    }

    /**
     * @param string $URL
     * @return $this
     */
    public function setURL($URL)
    {
        $this->URL = $URL;
        $this->data['URL'] = $this->getURL();
        return $this;
    }
}