<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 11:18 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message\Buttons;


class LogoutButton extends AbstractButton
{

    /**
     * set button type
     */
    protected function setType()
    {
        $this->type = self::ACCOUNT_UNLINK;
    }
}