<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 10:30 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Contracts;


interface MessageInterface extends DataWrapperInterface
{
    /**
     * return a class instance
     *
     * @param array $data
     * @return static
     */
    public static function create($data = []);
}