<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 9:50 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;


use Andre\Bionic\AbstractMessage;

abstract class Media extends AbstractMessage
{
    protected $file;

    protected $id;

    protected $mime_type;

    protected $sha256;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * @return mixed
     */
    public function getSha256()
    {
        return $this->sha256;
    }

}