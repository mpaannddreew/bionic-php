<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 7:05 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;

class Read extends AbstractMessage
{
    /**
     * @var int $watermark
     */
    protected $watermark;

    /**
     * @var int $seq
     */
    protected $seq;

    /**
     * @return int
     */
    public function getWatermark()
    {
        return $this->watermark;
    }

    /**
     * @return int
     */
    public function getSeq()
    {
        return $this->seq;
    }
}