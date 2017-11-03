<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 7:04 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;



class Delivery extends Read
{
    /**
     * @var array $mids
     */
    protected $mids = [];

    /**
     * @return array
     */
    public function getMids()
    {
        return $this->mids;
    }
}