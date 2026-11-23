<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;

use Andre\Bionic\Plugins\Telegram\PhotoSize;

class Document extends File
{
    /**
     * @var array $thumb
     */
    protected $thumb = [];

    /**
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @var string $mime_type
     */
    protected $mime_type;

    /**
     * @return PhotoSize|null
     */
    public function getThumb()
    {
        if ($this->thumb) {
            return PhotoSize::create($this->thumb);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }
}
