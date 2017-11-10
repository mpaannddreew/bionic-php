<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:16 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Contracts;


interface DataWrapperInterface
{
    /**
     * array representation of data
     */
    public function toArray();

    /**
     * json representation of data
     */
    public function toJson();

    /**
     * string representation of data
     */
    public function __toString();
}