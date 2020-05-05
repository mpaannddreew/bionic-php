<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 10:02 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;


use Andre\Bionic\AbstractMessage;

class Sticker extends AbstractMessage
{
    protected $id;

    protected $metadata = [];

    protected $mime_type;

    protected $sha256;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
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