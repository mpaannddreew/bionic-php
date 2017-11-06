<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 6:05 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\Plugins\Messenger\Messages\Payload\ButtonTemplatePayload;

class ButtonTemplate extends AbstractTemplate
{
    /**
     * @return ButtonTemplatePayload
     */
    public function getPayload()
    {
        return new ButtonTemplatePayload($this->payload);
    }
}