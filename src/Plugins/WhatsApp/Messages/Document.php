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
    protected $filename;

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }
}