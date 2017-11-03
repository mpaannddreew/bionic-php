<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 4:26 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments;


use Andre\Bionic\Plugins\Messenger\Messages\Message\AbstractAttachment;

class Fallback extends AbstractAttachment
{
    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var $URL
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
     * @return mixed
     */
    public function getURL()
    {
        return $this->URL;
    }
}