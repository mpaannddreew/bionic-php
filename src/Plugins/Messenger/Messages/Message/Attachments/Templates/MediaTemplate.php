<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 8:12 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\Plugins\Messenger\Messages\Payload\MediaTemplatePayload;

class MediaTemplate extends AbstractTemplate
{
    /**
     * get payload
     *
     * @return MediaTemplatePayload|null
     */
    public function getPayload()
    {
        if ($this->payload)
            return MediaTemplatePayload::create($this->payload);

        return null;
    }
}