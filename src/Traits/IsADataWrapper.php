<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 11:20 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Traits;


trait IsADataWrapper
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * array representation of data
     *
     * @return array
     */
    public function toArray(){
        return $this->data;
    }

    /**
     * json representation of data
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0){
        return json_encode($this->toArray(), $options);
    }

    /**
     * string representation of data
     *
     * @return string
     */
    public function __toString(){
        return $this->toJson();
    }
}