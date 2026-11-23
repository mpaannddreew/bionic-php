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

class Error extends AbstractMessage
{
    protected $code;

    protected $title;

    protected $details;

    protected $href;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $error_data = [];

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Error details. Current Graph API versions send them in
     * error_data.details; older ones sent a top-level details field.
     *
     * @return string|null
     */
    public function getDetails()
    {
        return $this->details ?? ($this->error_data['details'] ?? null);
    }

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getErrorData()
    {
        return $this->error_data;
    }
}
