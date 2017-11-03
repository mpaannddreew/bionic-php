<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 6:59 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;

class Optin extends AbstractMessage
{
    protected $ref;

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }
}