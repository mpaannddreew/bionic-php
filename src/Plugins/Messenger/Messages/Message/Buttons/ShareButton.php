<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:12 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class ShareButton extends AbstractButton
{

    /**
     * @var array $share_contents
     */
    protected $share_contents = [];

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::ELEMENT_SHARE;
    }
}