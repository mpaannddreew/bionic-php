<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;

use Andre\Bionic\AbstractMessage;

class Sticker extends AbstractMessage
{
    protected $id;

    protected $metadata = [];

    protected $mime_type;

    protected $sha256;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var bool
     */
    protected $animated = false;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * @return mixed
     */
    public function getSha256()
    {
        return $this->sha256;
    }

    /**
     * Media URL included in incoming webhooks. Download it with
     * WhatsAppPlugin::downloadMedia(); it expires after 5 minutes.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isAnimated()
    {
        return (bool) $this->animated;
    }
}
