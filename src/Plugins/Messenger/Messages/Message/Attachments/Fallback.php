<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 4:26 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * get URL
     *
     * @return string
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * set type
     */
    protected function setType()
    {
        $this->type = self::FALLBACK;
    }

    /**
     * set title
     *
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
     * set URL
     *
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