<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 5:10 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\Plugins\Messenger\Messages\Payload\GenericTemplatePayload;

class GenericTemplate extends AbstractTemplate
{

    /**
     * get payload
     *
     * @return GenericTemplatePayload
     */
    public function getPayload()
    {
        return GenericTemplatePayload::create($this->payload);
    }
}