<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:17 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class CallButton extends AbstractButton
{

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var string $payload
     */
    protected $payload;

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::PHONE_NUMBER;
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
}