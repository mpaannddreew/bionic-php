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
     * @var $watermark
     */
    protected $watermark;

    /**
     * @var $seq
     */
    protected $seq;

    /**
     * @return mixed
     */
    public function getWatermark()
    {
        return $this->watermark;
    }

    /**
     * @return mixed
     */
    public function getSeq()
    {
        return $this->seq;
    }
}