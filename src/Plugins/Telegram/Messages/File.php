<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/2/20
 * Time: 9:41 PM
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;


use Andre\Bionic\AbstractMessage;

class File extends AbstractMessage
{
    /**
     * @var string $file_id
     */
    protected $file_id;

    /**
     * @var string $file_unique_id
     */
    protected $file_unique_id;

    /**
     * @var int $file_size
     */
    protected $file_size;

    /**
     * @var string $file_path
     */
    protected $file_path;

    /**
     * @return string
     */
    public function getFileId()
    {
        return $this->file_id;
    }

    /**
     * @return string
     */
    public function getFileUniqueId()
    {
        return $this->file_unique_id;
    }

    /**
     * @return int
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->file_path;
    }
}