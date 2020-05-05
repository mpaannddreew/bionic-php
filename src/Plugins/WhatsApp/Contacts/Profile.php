<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 8:38 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Contacts;


use Andre\Bionic\AbstractMessage;

class Profile extends AbstractMessage
{
    protected $name;

    public function getName() {
        return $this->name;
    }
}