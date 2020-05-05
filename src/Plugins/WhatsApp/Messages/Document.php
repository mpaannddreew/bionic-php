<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 9:57 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;


class Document extends Media
{
    protected $caption;

    /**
     * @return mixed
     */
    public function getCaption()
    {
        return $this->caption;
    }
}