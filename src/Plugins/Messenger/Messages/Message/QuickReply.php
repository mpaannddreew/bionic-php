<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 1:36 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;

class QuickReply extends AbstractMessage
{
    /**
     * @var string $payload
     */
    protected $payload;

    /**
     * @var string $content_type
     */
    protected $content_type;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $image_url
     */
    protected $image_url;

    /**
     * get payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * set payload
     *
     * @param string $payload
     * @return $this
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
        $this->data['payload'] = $this->getPayload();
        return $this;
    }

    /**
     * get content type
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * set content type
     *
     * @param string $content_type
     * @return $this
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
        $this->data['content_type'] = $this->getContentType();
        return $this;
    }

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
     * get image url
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * set image url
     *
     * @param string $image_url
     * @return $this
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
        $this->data['image_url'] = $this->getImageUrl();
        return $this;
    }
}