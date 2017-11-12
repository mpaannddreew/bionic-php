<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 8:09 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


class MediaTemplatePayload extends GenericTemplatePayload
{
    /**
     * set template type
     */
    protected function setTemplateType()
    {
        $this->template_type = self::MEDIA;
    }
}