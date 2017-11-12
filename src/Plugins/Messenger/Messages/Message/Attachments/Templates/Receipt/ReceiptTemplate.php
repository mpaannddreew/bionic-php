<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 1:44 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\Receipt;


use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates\AbstractTemplate;
use Andre\Bionic\Plugins\Messenger\Messages\Payload\ReceiptTemplatePayload;

class ReceiptTemplate extends AbstractTemplate
{
    /**
     * get payload
     *
     * @return ReceiptTemplatePayload|null
     */
    public function getPayload()
    {
        if ($this->payload)
            return ReceiptTemplatePayload::create($this->payload);

        return null;
    }
}