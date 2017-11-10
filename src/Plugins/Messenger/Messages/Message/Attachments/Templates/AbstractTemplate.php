<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-04
 * Time: 9:56 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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