<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/6/20
 * Time: 12:41 AM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;

class ReplyTo extends AbstractMessage
{
    /**
     * @var $mid
     */
    protected $mid;

    /**
     * @return mixed
     */
    public function getMid()
    {
        return $this->mid;
    }
}