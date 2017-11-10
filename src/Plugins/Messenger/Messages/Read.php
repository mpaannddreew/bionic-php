<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 7:05 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
     * get watermark
     *
     * @return int
     */
    public function getWatermark()
    {
        return $this->watermark;
    }

    /**
     * get seq
     *
     * @return int
     */
    public function getSeq()
    {
        return $this->seq;
    }
}