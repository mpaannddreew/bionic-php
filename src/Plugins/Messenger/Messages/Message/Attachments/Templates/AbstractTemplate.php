<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 9:56 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\Templates;


use Andre\Bionic\Plugins\Messenger\Messages\Message\Attachments\AbstractAttachment;

abstract class AbstractTemplate extends AbstractAttachment
{

    /**
     * set type
     */
    protected function setType()
    {
        $this->type = self::TEMPLATE;
    }

}