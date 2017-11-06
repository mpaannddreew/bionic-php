<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 6:07 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\Plugins\Messenger\Messages\Payload\ListTemplatePayload;

class ListTemplate extends AbstractTemplate
{
    /**
     * @return ListTemplatePayload
     */
    public function getPayload()
    {
        return new ListTemplatePayload($this->payload);
    }
}