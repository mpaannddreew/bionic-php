<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 10:44 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\Plugins\Messenger\Messages\Payload\OpenGraphTemplatePayload;

class OpenGraphTemplate extends AbstractTemplate
{
    /**
     * get payload
     *
     * @return OpenGraphTemplatePayload
     */
    public function getPayload()
    {
        return OpenGraphTemplatePayload::create($this->payload);
    }
}