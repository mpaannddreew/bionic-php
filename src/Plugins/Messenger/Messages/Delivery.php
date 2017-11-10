<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 7:04 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;



class Delivery extends Read
{
    /**
     * @var array $mids
     */
    protected $mids = [];

    /**
     * get mids
     *
     * @return array
     */
    public function getMids()
    {
        return $this->mids;
    }
}