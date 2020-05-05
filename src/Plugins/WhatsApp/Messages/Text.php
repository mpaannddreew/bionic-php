<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 9:21 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;


use Andre\Bionic\AbstractMessage;

class Text extends AbstractMessage
{
    protected $body;

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }
}