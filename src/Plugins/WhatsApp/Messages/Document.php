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

class Document extends Media
{
    protected $filename;

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }
}
